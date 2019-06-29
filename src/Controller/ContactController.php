<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Services\ContactNotification;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * Page Contact
     * @Route("/contact", name="contact_index")
     * @param Request $request
     * @param ObjectManager $manager
     * @param ContactNotification $notification
     * @return Response
     */
    public function index(Request $request, ObjectManager $manager, ContactNotification $notification)
    {
        $contact = new Contact();

        $form = $this->createForm(ContactType::class, $contact);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $notification->notifyContact($contact);

            $manager->persist($contact);
            $manager->flush();

            $this->addFlash(
                'success',
                "{$contact->getName()}, votre message a bien été envoyé. Notre équipe vous contactera dans les plus bref délais."
            );

            return $this->redirectToRoute('contact_index');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
