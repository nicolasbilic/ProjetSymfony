<?php

namespace App\Form;

use App\Entity\Address;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressFormType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('number', NumberType::class, [
                'attr' => ['class' => 'custom-input-class'],
                'label_attr' => ['class' => 'custom-label-class'],
                'label' => 'Numéro',
            ])
            ->add('street', TextType::class, [
                'attr' => ['class' => 'custom-input-class'],
                'label_attr' => ['class' => 'custom-label-class'],
                'label' => 'Rue',
            ])
            ->add('additional', TextType::class, [
                'attr' => ['class' => 'custom-input-class'],
                'label_attr' => ['class' => 'custom-label-class'],
                'label' => 'Complément',
            ])
            ->add('city', TextType::class, [
                'attr' => ['class' => 'custom-input-class'],
                'label_attr' => ['class' => 'custom-label-class'],
                'label' => 'Ville',
            ])
            ->add('zip_code', NumberType::class, [
                'attr' => ['class' => 'custom-input-class'],
                'label_attr' => ['class' => 'custom-label-class'],
                'label' => 'Code Postal',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }
}
