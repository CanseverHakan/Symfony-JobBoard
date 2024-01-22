<?php

namespace App\Form;

use App\Entity\ContractType;
use App\Entity\EntrepriseProfil;
use App\Entity\Offer;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfferType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer le titre'
                ]
            ])
            ->add('shortDescription', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer une description'
                ]
            ])
            ->add('content', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Contenue de l\'offre'
                ]
            ])
            ->add('salary', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Salaire'
                ]
            ])
            ->add('location', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Localisation'
                ]
            ])
            ->add('contractType', EntityType::class, [
                'label' => false,
                'class' => ContractType::class,
                'choice_label' => 'name',
            ])
            ->add('tags', EntityType::class, [
                'label' => false,
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
