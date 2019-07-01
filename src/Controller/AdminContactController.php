<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Repository\ContactRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminContactController extends AbstractController
{
    /**
     * Show All Message Contact
     * @Route("/admin/contact", name="admin_contact_index")
     * @IsGranted("ROLE_ADMIN")
     * @param ContactRepository $repo
     * @return Response
     */
    public function index(ContactRepository $repo)
    {
        return $this->render('admin/contact/index.html.twig', [
            'contacts' => $repo->findAll()
        ]);
    }

    /**
     * Show Message Contact
     * @Route("/admin/contact/{id}/detail", name="admin_contact_showDetail")
     * @IsGranted("ROLE_ADMIN")
     * @param Contact $contact
     * @return Response
     */
    public function showDetail(Contact $contact)
    {
        return $this->render('admin/contact/showDetail.html.twig', [
            'contact' => $contact
        ]);
    }

    /**
     * Delete Message Contact
     * @Route("/admin/contact/{id}/delete", name="admin_contact_delete")
     * @IsGranted("ROLE_ADMIN")
     * @param Contact $contact
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Contact $contact, ObjectManager $manager)
    {
        $manager->remove($contact);
        $manager->flush();

        $this->addFlash(
            'success',
            "Le message de contact a bien été supprimé."
        );

        return $this->redirectToRoute('admin_contact_index');
    }
}
