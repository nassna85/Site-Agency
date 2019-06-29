<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'firstName',
                TextType::class, [
                    'label' => "Prénom",
                    'attr' => [
                        'placeholder' => "Votre Prénom"
                    ]
                ]
            )
            ->add(
                'lastName',
                TextType::class, [
                    'label' => "Nom",
                    'attr' => [
                        'placeholder' => "Votre Nom"
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class, [
                    'label' => "Email",
                    'attr' => [
                        'placeholder' => "Votre Email"
                    ]
                ]
            )
            ->add(
                'avatar',
                UrlType::class, [
                    'label' => "Avatar",
                    'required' => false,
                    'attr' => [
                        'placeholder' => "URL de votre avatar"
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
