<?php

namespace App\Controller;

use App\Entity\Options;
use App\Form\AdminPropertiesOptionsType;
use App\Repository\OptionsRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertiesOptionsController extends AbstractController
{
    /**
     * Show List of the options for properties
     * @Route("/admin/properties-options", name="admin_propertiesOptions_index")
     * @IsGranted("ROLE_ADMIN")
     * @param OptionsRepository $repo
     * @return Response
     */
    public function index(OptionsRepository $repo)
    {
        return $this->render('admin/propertiesOptions/index.html.twig', [
            'options' => $repo->findAll()
        ]);
    }

    /**
     * Create option for properties
     * @Route("/admin/properties-options/create", name="admin_propertiesOptions_create")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function create(Request $request, ObjectManager $manager)
    {
        $option = new Options();

        $form = $this->createForm(AdminPropertiesOptionsType::class, $option);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($option);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'option {$option->getName()} a bien été enregistrée"
            );

            return $this->redirectToRoute('admin_propertiesOptions_index');
        }

        return $this->render('admin/propertiesOptions/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit a option
     * @Route("/admin/properties-options/{id}/edit", name="admin_propertiesOptions_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param Options $option
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Options $option, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdminPropertiesOptionsType::class, $option);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($option);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'option a bien été modifiée."
            );

            return $this->redirectToRoute('admin_propertiesOptions_index');
        }
        return $this->render('admin/propertiesOptions/edit.html.twig', [
            'option' => $option,
            'form' => $form->createView()
        ]);
    }

    /**
     * Delete Option
     * @Route("/admin/properties-options/{id}/delete", name="admin_propertiesOptions_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Options $option
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Options $option, ObjectManager $manager)
    {
        $manager->remove($option);
        $manager->flush();

        $this->addFlash(
            'success',
            "L'option a bien été supprimée."
        );

        return $this->redirectToRoute('admin_propertiesOptions_index');
    }
}
