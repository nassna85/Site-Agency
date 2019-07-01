<?php

namespace App\Form;

use App\Entity\ContactForProperty;
use App\Entity\Properties;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminContactForPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'author',
                EntityType::class, [
                    'class' => User::class,
                    'choice_label' => 'fullName',
                    'label' => "Auteur"
                ]
            )
            ->add(
                'property',
                EntityType::class, [
                    'class' => Properties::class,
                    'choice_label' => 'id',
                    'label' => "Propriété conçernée"
                ]
            )
            ->add(
                'message',
                TextareaType::class, [
                    'label' => "Message",
                ]
            )
            ->add(
                'answered',
                CheckboxType::class, [
                    'label' => "Une réponse a été envoyée au client ?",
                    'required' => false,
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ContactForProperty::class,
        ]);
    }
}
