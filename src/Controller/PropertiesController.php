<?php

namespace App\Controller;

use App\Entity\ContactForProperty;
use App\Entity\Properties;
use App\Entity\PropertiesSearch;
use App\Entity\PropertyLike;
use App\Form\ContactForPropertyType;
use App\Form\PropertiesSearchType;
use App\Form\PropertiesType;
use App\Repository\PropertiesRepository;
use App\Repository\PropertyLikeRepository;
use App\Services\ContactNotification;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PropertiesController extends AbstractController
{
    /**
     * show All Properties
     * @Route("/properties", name="properties_index")
     * @param PropertiesRepository $repo
     * @param Request $request
     * @return Response
     */
    public function index(PropertiesRepository $repo, Request $request)
    {
        $search = new PropertiesSearch();

        $properties =  $repo->findAll();

        $form = $this->createForm(PropertiesSearchType::class, $search);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $action = ($form->get('action')->getNormData());
            $type = ($form->get('type')->getNormData());
            $maxPrice = ($form->get('maxPrice')->getNormData());
            $minBedroom = ($form->get('minBedroom')->getNormData());
            $minArea = ($form->get('minArea')->getNormData());

            if($maxPrice == null)
            {
                $maxPrice = 99999999999;
            }
            if($minBedroom == null)
            {
                $minBedroom = 1;
            }
            if($minArea == null)
            {
                $minArea = 10;
            }

            $properties = $repo->PropertiesSearchByCriteria($action, $type, $maxPrice, $minBedroom, $minArea);
        }
        return $this->render('properties/index.html.twig', [
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * Show only Properties for Sale
     * @Route("/properties/for-sale", name="properties_index_sale")
     * @param $repo
     * @return Response
     */
    public function showPropertiesForSale(PropertiesRepository $repo)
    {
        $properties = $repo->findByAction('vendre');

        return $this->render('properties/showPropertiesForSale.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * Permet de voir toutes les annonces à louer
     * @Route("/properties/for-rent", name="properties_index_rent")
     * @param $repo
     * @return Response
     */
    public function showPropertiesForRent(PropertiesRepository $repo)
    {
        $properties = $repo->findByAction('louer');

        return $this->render('properties/showPropertiesForRent.html.twig', [
            'properties' => $properties
        ]);
    }

    /**
     * Show One Property
     * @Route("/property/{id}/show", name="properties_show", requirements={"id"="\d+"})
     * @param Properties $property
     * @param Request $request
     * @param ObjectManager $manager
     * @param ContactNotification $notification
     * @return Response
     */
    public function show(Properties $property, Request $request, ObjectManager $manager, ContactNotification $notification)
    {
        $contact = new ContactForProperty();

        $contact->setProperty($property);

        $form = $this->createForm(ContactForPropertyType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $user = $this->getUser();

            $contact->setAuthor($user);

            $notification->notifyContactForProperty($contact);

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre message pour le bien n° {$property->getId()} a bien été envoyé. Merci"
            );

            return $this->redirectToRoute('properties_show', [
                'id' => $property->getId()
            ]);
        }

        return $this->render('properties/show.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * Create New Property
     * @Route("/property/new", name="properties_new")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $property = new Properties();

        $form = $this->createForm(PropertiesType::class, $property);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach ($property->getImages() as $image)
            {
                $image->setProperty($property);
                $manager->persist($image);
            }

            $user = $this->getUser();
            $property->setAuthor($user);

            $manager->persist($property);
            $manager->flush();

            $this->addFlash(
              'success',
              "{$user->getFirstName()}, votre bien a bien été enregistré. Celui-ci sera publié dans les 24h. Merci de votre confiance."
            );

            return $this->redirectToRoute('properties_index');
        }


        return $this->render('properties/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit property
     * @Route("/property/{id}/edit", name="properties_edit")
     * @Security("is_granted('ROLE_USER') and user === property.getAuthor()", message="Cette annonce ne vous appartient pas !")
     * @param $property
     * @param $request
     * @param $manager
     * @return Response
     */
    public function update(Properties $property, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(PropertiesType::class, $property);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            foreach ($property->getImages() as $image)
            {
                $image->setProperty($property);
                $manager->persist($image);
            }

            $manager->persist($property);
            $manager->flush();

            $this->addFlash(
                'success',
                "Votre bien a bien été mise à jour. Merci !"
            );

            return $this->redirectToRoute('properties_show', [
                'id' => $property->getId()
            ]);
        }


        return $this->render('properties/edit.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete Property
     * @Route("/property/{id}/delete", name="properties_delete")
     * @Security("is_granted('ROLE_USER') and user === property.getAuthor()", message="Cette annonce ne vous appartient pas. Pas possible de la supprimer !")
     * @param $property
     * @param $manager
     * @return Response
     */
    public function delete(Properties $property, ObjectManager $manager)
    {
        $manager->remove($property);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre bien a bien été supprimé. Merci."
        );

        return $this->redirectToRoute('properties_index');
    }

    /**
     * For to like or no a property
     * @Route("/property/{id}/like", name="property_like")
     * @param Properties $property
     * @param ObjectManager $manager
     * @param PropertyLikeRepository $likeRepo
     * @return Response
     */
    public function like(Properties $property, ObjectManager $manager, PropertyLikeRepository $likeRepo)
    {
        $user = $this->getUser();

        //If user no connected

        if(!$user)
        {
            return $this->json([
               'code' => 403,
               'message' => "Pas autorisé"
            ], 403);
        }

        //If user like already this property => Remove like

        if($property->isLikedByUser($user))
        {
            $like = $likeRepo->findOneBy([
               'property' => $property,
                'user' => $user
            ]);

            $manager->remove($like);
            $manager->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like remove',
                'likes' => $likeRepo->count(['property'=> $property])
            ], 200);
        }

        //If User will like this property => add Like

        $like = new PropertyLike();
        $like->setProperty($property)
             ->setUser($user);

        $manager->persist($like);
        $manager->flush();

        return $this->json([
            'code'=> 200,
            'message'=> "Like add",
            'likes' => $likeRepo->count(['property'=>$property])
        ], 200);
    }
}
