<?php

namespace App\Form;

use App\Entity\UserProfil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre prénom'
                ]
            ])
            ->add('lastName', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre nom'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre address'
                ]
            ])
            ->add('zipCode', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre Code Postal'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre Ville'
                ]
            ])
            ->add('country', CountryType::class, [
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
                    'placeholder' => 'Entrer votre Numeros'
                ]
            ])
            ->add('jobSought', TextType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer le Poste recherché'
                ]
            ])
            ->add('presentation', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Présentez-vous en quelques mots'
                    
                ]
            ])
            ->add('website', UrlType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Entrer votre site'
                ]
            ])
            ->add('imageFile', FileType::class, [
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
            ->add('availability', CheckboxType::class, [
                'label' => 'Etes-vous disponible ?',
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserProfil::class,
        ]);
    }
}
