<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Entity\Category;
use App\Entity\Tva;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ProductFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => function (Category $category): string {
                    return $category->getName();
                }
            ])
            ->add('name')
            ->add('price')
            ->add('description')
            ->add('discount')
            ->add('tva', EntityType::class, [
                'class' => Tva::class,
                'choice_label' => function (Tva $tva): string {
                    return $tva->getValue() . '%';
                }
            ])
            ->add('file', FileType::class, [
                'mapped' => false, // This tells Symfony not to try to map this field to an entity property
                'required' => false, // Set this to true if the file field is mandatory
            ])
            ->add('stock', null, [
                'data' => 1, // Remplacez 1 par la valeur par défaut que vous souhaitez
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
