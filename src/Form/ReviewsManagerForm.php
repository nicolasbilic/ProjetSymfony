<?php

namespace App\Form;

use App\Entity\Review;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewsManagerFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $today = new \DateTime();
        $builder
            ->add('value', IntegerType::class, [
                'attr' => [
                    'style' => 'text-align:center;',
                    'class' => 'inputright',
                    'style' => 'display: none;',
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('title', null, [
                'attr' => [
                    'style' => 'text-align:center;',
                    'class' => 'inputright',
                    'style' => 'display: none;',
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('resume', null, [
                'attr' => [
                    'style' => 'text-align:center;',
                    'class' => 'inputright',
                    'style' => 'display: none;',
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('state', ChoiceType::class, [
                'choices' => [
                    'en attente' => 'pending',
                    'approuvé' => 'approved',
                    'refusé' => 'declined',
                ],
                'label' => 'Statut',
                'required' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
