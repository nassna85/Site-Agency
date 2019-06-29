<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiesSearchType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'action',
                ChoiceType::class, [
                    'placeholder' => false,
                    'label' => false,
                    'choices' => [
                        'A louer' => "louer",
                        'A vendre' => "vendre"
                    ]

                ]
            )
            ->add(
                'type',
                ChoiceType::class, [
                    'placeholder' => false,
                    'label' => false,
                    'choices' => [
                        'Appartement' => "Appartement",
                        'Maison' => "Maison",
                        'Villa' => "Villa"
                    ]
                ]
            )
            ->add(
                'maxPrice',
                MoneyType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => "Prix maximum"
                    ]
                ]
            )
            ->add(
                'minBedroom',
                NumberType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => "Chambre minimum"
                    ]
                ]
            )
            ->add(
                'minArea',
                NumberType::class, [
                    'label' => false,
                    'required' => false,
                    'attr' => [
                        'placeholder' => "Surface minimum"
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
