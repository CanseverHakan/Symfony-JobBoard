<?php

namespace App\Form;

use App\Entity\EntrepriseProfil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class EntrepriseProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez le nom votre Entreprise'
                ]
            ])
            ->add('address',TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez l\'addresse'
                ]
            ])
            ->add('city',TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez la ville'
                ]
            ])
            ->add('zipCode',TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez le code postale'
                ]
            ])
            ->add('country',CountryType::class, [
                'label' => false,
                'preferred_choices' => [
                    'FR',
                    'BE',
                    'CH',
                    'LU'
                ]
            ])
            ->add('phoneNumber', TelType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez le numeros de telephone'
                ]
            ] )
            ->add('activityArea',TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez le secteur d\'activité'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez l\'email de l\'entreprise'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrez la description l\'entreprise'
                ]
            ])
            ->add('logo', FileType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'enctype' => 'multipart/form-data'
                ],
                'constraints' => [
                    new Image([
                        'maxSize' => "3M",
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/jpg'
                        ],
                        'mimeTypesMessage' => 'Merci d\'uploader une image de type jpg, jpeg, png ou webp',
                    ])
                ]
            ])
            ->add('website', UrlType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer le site de l\'entreprise'
                ]
            ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EntrepriseProfil::class,
        ]);
    }
}
