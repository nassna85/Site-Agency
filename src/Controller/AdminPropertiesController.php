<?php

namespace App\Controller;

use App\Entity\Properties;
use App\Form\AdminPropertiesType;
use App\Repository\PropertiesRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminPropertiesController extends AbstractController
{
    /**
     * @Route("/admin/properties", name="admin_properties_index")
     * @IsGranted("ROLE_ADMIN")
     * @param PropertiesRepository $repo
     * @return Response
     */
    public function index(PropertiesRepository $repo)
    {
        return $this->render('admin/properties/index.html.twig', [
            'properties' => $repo->findAll()
        ]);
    }

    /**
     * Check Property before approved
     * @Route("/admin/property/{id}/show", name="admin_properties_show")
     * @IsGranted("ROLE_ADMIN")
     * @param Properties $property
     * @return Response
     */
    public function showProperty(Properties $property)
    {
        return $this->render('admin/properties/show.html.twig', [
            'property' => $property
        ]);
    }

    /**
     * Check detail property
     * @Route("/admin/property/{id}/details", name="admin_properties_show_detail")
     * @IsGranted("ROLE_ADMIN")
     * @param Properties $property
     * @return Response
     */
    public function showDetailProperty(Properties $property)
    {
        return $this->render('admin/properties/show_detail.html.twig', [
            'property' => $property
        ]);
    }

    /**
     * Edit property and approuve this if correct
     * @Route("/admin/property/{id}/edit", name="admin_properties_edit")
     * @IsGranted("ROLE_ADMIN")
     * @param Properties $property
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Properties $property, Request $request, ObjectManager $manager)
    {
        $form = $this->createForm(AdminPropertiesType::class, $property);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($property);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le bien n° {$property->getId()} a bien été modifié."
            );

            return $this->redirectToRoute('admin_properties_index');
        }


        return $this->render('admin/properties/edit.html.twig', [
            'form' => $form->createView(),
            'property' => $property
        ]);
    }

    /**
     * Delete property
     * @Route("/admin/property/{id}/delete", name="admin_properties_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Properties $property
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Properties $property, ObjectManager $manager)
    {
        $manager->remove($property);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le bien a bien été supprimé !"
        );

        return $this->redirectToRoute('admin_properties_index');
    }
}
