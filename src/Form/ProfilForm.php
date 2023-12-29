<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProfilForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'Prénom :',
            ])
            ->add('name', TextType::class, [
                'label' => 'Nom :',
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email :',
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Mot-de-passe :',
            ])
            ->add('picture', FileType::class, [
                'mapped' => false, // This field is not mapped to an entity property
                'required' => false, // The file input is not required
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}
