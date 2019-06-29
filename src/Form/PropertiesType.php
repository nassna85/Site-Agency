<?php

namespace App\Form;

use App\Entity\Properties;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'type',
                ChoiceType::class, [
                    'label' => "Type",
                    'choices' => [
                        'Appartement' => "Appartement",
                        'Maison' => "Maison",
                        'Villa' => "Villa"
                    ]
                ]
            )
            ->add(
                'action',
                ChoiceType::class, [
                    'label' => "Action",
                    'choices' => [
                        'A vendre' => "vendre",
                        'A louer' => "louer"
                    ]
                ]
            )
            ->add(
                'city',
                TextType::class, [
                    'label' => "Ville",
                    'attr' => [
                        'placeholder' => "Ville du bien"
                    ]
                ]
            )
            ->add(
                'address',
                TextType::class, [
                    'label' => "Adresse",
                    'attr' => [
                        'placeholder' => "Adresse du bien"
                    ]
                ]
            )
            ->add(
                'postalCode',
                TextType::class, [
                    'label' => "Code postal",
                    'attr' => [
                        'placeholder' => "Code postal du bien",
                    ]
                ]
            )
            ->add(
                'price',
                MoneyType::class, [
                    'label' => "Prix",
                    'attr' => [
                        'placeholder' => "Prix du bien",
                        'min' => 0
                    ]
                ]
            )
            ->add(
                'area',
                IntegerType::class, [
                    'label' => "Surface",
                    'attr' => [
                        'placeholder' => "Surface en m2",
                        'min' => 0
                    ]
                ]
            )
            ->add(
                'bedrooms',
                IntegerType::class, [
                    'label' => "Chambres",
                    'attr' => [
                        'placeholder' => "Nombre de chambres",
                        'min' => 0
                    ]
                ]
            )
            ->add(
                'shower',
                IntegerType::class, [
                    'label' => "Douche",
                    'attr' => [
                        'placeholder' => "Nombre de douches",
                        'min' => 0
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class, [
                    'label' => "Description",
                    'attr' => [
                        'placeholder' => "Décrivez votre bien"
                    ]
                ]
            )
            ->add(
                'coverImage',
                UrlType::class, [
                    'label' => "Image Principale",
                    'attr' => [
                        'placeholder' => "Indiquer l'URL de votre image principale",
                    ]
                ]
            )
            ->add(
                'images',
                CollectionType::class, [
                    'label' => false,
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Properties::class,
        ]);
    }
}
