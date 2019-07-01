<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserAdminType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class, [
                    'label' => "Prénom",
                    'attr' => [
                        'placeholder' => "Prénom"
                    ]
                ]
            )
            ->add(
                'lastName',
                TextType::class, [
                    'label' => "Nom",
                    'attr' => [
                        'placeholder' => "Nom"
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class, [
                    'label' => "Email",
                    'attr' => [
                        'placeholder' => "Adresse email"
                    ]
                ]
            )
            ->add(
                'avatar',
                UrlType::class, [
                    'label' => "Avatar",
                    'required' => false,
                    'attr' => [
                        'placeholder' => "URL de l'avatar"
                    ]
                ]
            )
            ->add(
                'password',
                PasswordType::class, [
                    'label' => "Mot de passe",
                    'attr' => [
                        'placeholder' => "Votre mot de passe"
                    ]
                ]
            )
            ->add(
                'passwordConfirm',
                PasswordType::class, [
                    'label' => "Confimation de mot de passe",
                    'attr' => [
                        'placeholder' => "Confirmer votre mot de passe"
                    ]
                ]
            )
            ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'User' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                    'label' => "Choississez le rôle"
                ]
            )
            ->add(
                'active',
                CheckboxType::class, [
                    'required' => true,
                    'label' => "Activation du compte"
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'validation_groups' => [
                'Default',
                "registration"
            ]
        ]);
    }
}
