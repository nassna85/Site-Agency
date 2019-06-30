<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class, [
                    'label' => "Prénom",
                    'attr' => [
                        'placeholder' => "Modifier le prénom"
                    ]
                ]
            )
            ->add(
                'lastName',
                TextType::class, [
                    'label' => "Nom",
                    'attr' => [
                        'placeholder' => "Modifier le nom"
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class, [
                    'label' => "Email",
                    'attr' => [
                        'placeholder' => "Modifier l'adresse email"
                    ]
                ]
            )
            ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'User' => 'ROLE_USER',
                        'Admin' => 'ROLE_ADMIN',
                    ],
                    'multiple' => true,
                ]
            )
            ->add(
                'avatar',
                UrlType::class, [
                    'label' => "Avatar",
                    'required' => false,
                    'attr' => [
                        'placeholder' => "Modifier l'URL de l'avatar"
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
