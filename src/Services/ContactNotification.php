<?php


namespace App\Services;

use App\Entity\Contact;
use App\Entity\ContactForProperty;
use Twig\Environment;

class ContactNotification
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var Environment
     */
    private $renderer;

    public function __construct(\Swift_Mailer $mailer, Environment $renderer)
    {
        $this->mailer = $mailer;
        $this->renderer = $renderer;
    }


    public function notifyContact(Contact $contact)
    {
        $message = (new \Swift_Message("House Agency - Demande de contact de " . $contact->getName()))
            ->setFrom($contact->getEmail())
            ->setTo("nassna85@hotmail.fr")
            ->setReplyTo($contact->getEmail())
            ->setBody($this->renderer->render('email/contact.html.twig', [
                'contact' => $contact
            ]), 'text/html');

        $this->mailer->send($message);
    }


    public function notifyContactForProperty(ContactForProperty $contactProperty)
    {
        $message = (new \Swift_Message("House Agency - Demande de renseignement pour le bien numéro" . $contactProperty->getId()))
            ->setFrom($contactProperty->getAuthor()->getEmail())
            ->setTo("nassna85@hotmail.fr")
            ->setReplyTo($contactProperty->getAuthor()->getEmail())
            ->setBody($this->renderer->render('email/contactForProperty.html.twig', [
                'contactForProperty' => $contactProperty
            ]), 'text/html');

        $this->mailer->send($message);
    }


}