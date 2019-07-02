<?php

namespace App\Form;

use App\Entity\Options;
use App\Entity\Properties;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminPropertiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'type',
                TextType::class, [
                    'label' => "Type",
                    'attr' => [
                        'placeholder' => "Indiquer le type du bien"
                    ]
                ]
            )
            ->add(
                'action',
                TextType::class, [
                    'label' => "Action",
                    'attr' => [
                        'placeholder' => "Indiquer l'action du bien"
                    ]
                ]
            )
            ->add(
                'city',
                TextType::class, [
                    'label' => "Ville",
                    'attr' => [
                        'placeholder' => "Indiquer la ville du bien"
                    ]
                ]
            )
            ->add(
                'address',
                TextType::class, [
                    'label' => "Adresse",
                    'attr' => [
                        'placeholder' => "Indiquer l'adresse du bien"
                    ]
                ]
            )
            ->add(
                'postalCode',
                TextType::class, [
                    'label' => "Code postal",
                    'attr' => [
                        'placeholder' => "Indiquer le code postal"
                    ]
                ]
            )
            ->add(
                'price',
                MoneyType::class, [
                    'label' => "Prix",
                    'attr' => [
                        'placeholder' => "Indiquer le prix"
                    ]
                ]
            )
            ->add(
                'sold',
                CheckboxType::class, [
                    'label' => "Le bien a t-il été vendu ou loué ?",
                    'required' => false
                ]
            )
            ->add(
                'area',
                IntegerType::class, [
                    'label' => "Surface du bien",
                    'attr' => [
                        'placeholder' => "Indiquer la surface du bien en m2",
                        'min' => 1,
                    ]
                ]
            )
            ->add(
                'bedrooms',
                IntegerType::class, [
                    'label' => "Nombre de chambres",
                    'attr' => [
                        'placeholder' => "Indiquer le nombre de chambre",
                        'min' => 1,
                    ]
                ]
            )
            ->add(
                'shower',
                IntegerType::class, [
                    'label' => "Nombre de douches",
                    'attr' => [
                        'placeholder' => "Indiquer le nombre de douches",
                        'min' => 1,
                    ]
                ]
            )
            ->add(
                'description',
                TextareaType::class, [
                    'label' => "Description",
                    'attr' => [
                        'placeholder' => "Decrivez votre bien"
                    ]
                ]
            )
            ->add(
                'coverImage',
                UrlType::class, [
                    'label' => "L'URL de votre image principale",
                    'attr' => [
                        'placeholder' => "Indiquer l'URL de votre image principale"
                    ]
                ]
            )
            ->add(
                'images',
                CollectionType::class, [
                    'label' => "Vos images",
                    'entry_type' => ImageType::class,
                    'allow_add' => true,
                    'allow_delete' => true
                ]
            )
            ->add(
                'approved',
                CheckboxType::class, [
                    'label' => "Bien vérifié ?",
                    'required' => false
                ]
            )
            ->add(
                'author',
                EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'fullName',
                    'label' => "Auteur"
                ]
            )
            ->add(
                'options',
                EntityType::class, [
                    'class' => Options::class,
                    'choice_label' => "name",
                    'multiple' => true,
                    'expanded' => true,
                    'label' => "Séléctionner des options",
                    'required' => false
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
