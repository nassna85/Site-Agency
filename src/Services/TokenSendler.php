<?php

namespace App\Services;


use App\Entity\Token;
use App\Entity\User;
use Twig\Environment;

class TokenSendler
{
    private $mailer;
    private $twig;

    /**
     * TokenSendler constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $twig
     */
    public function __construct(\Swift_Mailer $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendToken(User $user, Token $token)
    {
        $message = (new \Swift_Message('House Agency : Confirmation de votre inscription.'))
                ->setFrom('info@house-agency.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->twig->render(
                        'email/registrationConfirm.html.twig',
                        ['token' => $token->getValue(), 'user' => $user]
                    ),
                    'text/html'
                );
        $this->mailer->send($message);
    }
}