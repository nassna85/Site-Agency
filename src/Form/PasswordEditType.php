<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'oldPassword',
                PasswordType::class, [
                    'label' => "Mot de passe actuel",
                    'attr' => [
                        'placeholder' => "Entrez le mot de passe actuel"
                    ]
                ]
            )
            ->add(
                'newPassword',
                PasswordType::class, [
                    'label' => "Nouveau mot de passe",
                    'attr' => [
                        'placeholder' => "Entrez le nouveau mot de passe"
                    ]
                ]
            )
            ->add(
                'passwordConfirm',
                PasswordType::class, [
                    'label' => "Confirmation du nouveau mot de passe",
                    'attr' => [
                        'placeholder' => "Confirmez le nouveau mot de passe"
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
