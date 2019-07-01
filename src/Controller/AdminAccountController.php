<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUserAdminType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminAccountController extends AbstractController
{
    /**
     * Login Admin
     * @Route("/admin/login", name="admin_account_login")
     * @param AuthenticationUtils $utils
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();

        $username = $utils->getLastUsername();

        return $this->render('admin/account/login.html.twig', [
            'hasError' => $error != null,
            'username' => $username
        ]);
    }

    /**
     * Logout Admin
     * @Route("/admin/logout", name="admin_account_logout")
     */
    public function logout()
    {

    }

    /**
     * Register a user with userRole admin
     * @Route("/admin/user-admin-registration", name="admin_account_registrationUserAdmin")
     * @IsGranted("ROLE_ADMIN")
     * @param Request $request
     * @param ObjectManager $manager
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function adminUserRegistration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $adminUser = new User();

        $form = $this->createForm(AdminUserAdminType::class, $adminUser);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $hash = $encoder->encodePassword($adminUser, $adminUser->getPassword());

            $adminUser->setPassword($hash);

            $manager->persist($adminUser);
            $manager->flush();

            $this->addFlash(
                'success',
                "Le compte avec l'email '{$adminUser->getEmail()}' a bien été enregistré"
            );

            return $this->redirectToRoute('admin_users_index');
        }
        return $this->render('admin/account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
