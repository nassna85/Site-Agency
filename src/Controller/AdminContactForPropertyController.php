<?php

namespace App\Controller;

use App\Entity\ContactForProperty;
use App\Form\AdminContactForPropertyType;
use App\Repository\ContactForPropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactForPropertyController extends AbstractController
{
    /**
     * @Route("/admin/contact-for-property", name="admin_contactForProperty_index")
     * @param ContactForPropertyRepository $repo
     * @return Response
     */
    public function index(ContactForPropertyRepository $repo)
    {
        return $this->render('admin/contact_for_property/index.html.twig', [
            'contactForProperties' => $repo->findAll()
        ]);
    }

    /**
     * Edit contact for property, possibility to confirm answer
     * @Route("/admin/contact-for-property/{id}/edit", name="admin_contactForProperty_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param ContactForProperty $contactForProperty
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(ContactForProperty $contactForProperty, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdminContactForPropertyType::class, $contactForProperty);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($contactForProperty);
            $manager->flush();

            $this->addFlash(
              'success',
              "Les modifications ont bien été enregistrées."
            );
            return $this->redirectToRoute('admin_contactForProperty_index');
        }

        return $this->render('admin/contact_for_property/edit.html.twig', [
            'form' => $form->createView(),
            'contactForProperty' => $contactForProperty
        ]);
    }

    /**
     * Show Detail Message
     * @Route("/admin/contact-for-property/{id}/detail", name="admin_contactForProperty_detail")
     * @param ContactForProperty $contactForProperty
     * @return Response
     */
    public function showDetail(ContactForProperty $contactForProperty)
    {
        return $this->render('admin/contact_for_property/showDetail.html.twig', [
            'contactForProperty' => $contactForProperty
        ]);
    }

    /**
     * Delete Message of contact property
     * @Route("/admin/contact-for-property/{id}/delete", name="admin_contactForProperty_delete")
     * @param ContactForProperty $contactForProperty
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(ContactForProperty $contactForProperty, ObjectManager $manager)
    {
        $manager->remove($contactForProperty);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le message a bien été supprimé."
        );

        return $this->redirectToRoute('admin_contactForProperty_index');
    }
}
