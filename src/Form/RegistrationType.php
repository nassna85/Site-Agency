<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class, [
                    'label' => false,
                    'attr' => [
                        'placeholder' => "Prénom",
                    ]
                ]
            )
            ->add(
                'lastName',
                TextType::class, [
                    'label' => false,
                    'attr' => [
                        'placeholder' => "Nom"
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class, [
                    'label' => false,
                    'attr' => [
                        'placeholder' => "Email"
                    ]
                ]
            )
            ->add(
                'avatar',
                UrlType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => "URL avatar"
                    ]
                ]
            )
            ->add(
                'password',
                PasswordType::class, [
                    'label' => false,
                    'attr' => [
                        'placeholder' => "Mot de passe"
                    ]
                ]
            )
            ->add(
                'passwordConfirm',
                PasswordType::class, [
                    'label' => false,
                    'attr' => [
                        'placeholder' => "Répéter le mot de passe"
                    ]
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
