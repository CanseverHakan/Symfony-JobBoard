<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Offer;
use App\Entity\Application;
use App\Entity\EntrepriseProfil;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('message', TextareaType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Veuillez écrire votre message ici, afin de convaincre l\'entreprise de vous recruter',
                    'rows' => 10,
                    'class' => 'mt-5'

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
