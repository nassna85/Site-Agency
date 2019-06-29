<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Entity\PasswordEdit;
use App\Entity\Token;
use App\Entity\User;
use App\Form\AccountType;
use App\Form\CommentType;
use App\Form\PasswordEditType;
use App\Form\RegistrationType;
use App\Services\TokenSendler;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     * @return void
     */
    public function logout()
    {

    }

    /**
     * Form Registration
     * @Route("/inscription", name="account_registration")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @param TokenSendler $tokenSendler
     * @return Response
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder, TokenSendler $tokenSendler)
    {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($user, $user->getPassword() );

            $user->setPassword($hash)
                 ->setRoles(['ROLE_USER']);

            $token = new Token($user);
            //Persist token, automatically persist also user because cascade
            $manager->persist($token);
            $manager->flush();

            $tokenSendler->sendToken($user, $token);

            $this->addFlash(
                'success',
                "Votre compte a bien été enregistré. Un email vous a été envoyé. Veuillez cliquez sur le lien afin d'activer votre compte !"
            );

            return $this->redirectToRoute('homepage');
        }

        return $this->render('account/register.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Confirm or no Validation Token by User
     * @Route("/registration-confirmation/{value}", name="account_validation_token")
     * @param Token $token
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function validateToken(Token $token, ObjectManager $manager)
    {
        $user = $token->getUser();

        if($user->getActive())
        {
            return $this->redirectToRoute('homepage', [
                'tokenAlreadyValidated' => true,
            ]);
        }

        //isValid is a function in Token.php
        if($token->isValid())
        {
            $user->setActive(true);
            $manager->flush();

            return $this->redirectToRoute('account_login', [
                'validationSuccess' => true
            ]);
        }

        //If token not valid, remove user and token in database
        // Remove only token because cascade!!
        $manager->remove($token);
        $manager->flush();

        return $this->redirectToRoute('account_registration', [
            'tokenExpired' => true,
        ]);
    }

    /**
     * Show account User
     * @Route("/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function myAccount(Request $request, ObjectManager $manager)
    {
        $comment = new Comments();

        $user = $this->getUser();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $comment->setAuthor($user);
            $manager->persist($comment);
            $manager->flush();

            $this->addFlash(
                'success',
                "{$user->getFirstName()}, votre commentaire a bien été enregistré. Nous vous remercions pour l'intêret que vous portez à notre agence."
            );

            return $this->redirectToRoute('account_profile');
        }

        return $this->render('account/myAccount.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Update profile user
     * @Route("/profile/edit", name="account_edit")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param ObjectManager $manager
     * @return Response
     */
    public function editAccount(Request $request, ObjectManager $manager)
    {
        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                "{$user->getFirstName()}, votre profil a bien été modifié."
            );

            return $this->redirectToRoute('account_profile');
        }
        return $this->render('account/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edit password User
     * @Route("/profile/password-edit", name="account_passwordEdit")
     * @IsGranted("ROLE_USER")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function passwordEdit(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $password = new PasswordEdit();

        $user = $this->getUser();

        $form = $this->createForm(PasswordEditType::class, $password);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            if(!password_verify($password->getOldPassword(), $user->getPassword()))
            {
                //Error
                $form->get('oldPassword')->addError(new FormError("Le mot de passe que vous avez entré n'est pas le mot de passe actuel !"));
            }
            else
            {
                $newPassword = $password->getNewPassword();

                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setPassword($hash);

                $manager->persist($user);

                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passe a été modifié avec succès."
                );

                return $this->redirectToRoute('account_profile');
            }
        }

        return $this->render('account/passwordEdit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }
}
