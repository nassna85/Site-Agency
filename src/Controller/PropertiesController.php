<?php

namespace App\Controller;

use App\Entity\ContactForProperty;
use App\Entity\Properties;
use App\Form\ContactForPropertyType;
use App\Repository\PropertiesRepository;
use App\Services\ContactNotification;
use Doctrine\Common\Persistence\ObjectManager;
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
     * @return Response
     */
    public function index(PropertiesRepository $repo)
    {
        return $this->render('properties/index.html.twig', [
            'properties' => $repo->findAll()
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
     * @Route("/property/{id}", name="properties_show")
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
}
