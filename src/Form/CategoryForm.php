<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class CategoryFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('parent', EntityType::class, [
                'class' => Category::class, // 
                'choice_label' => function (Category $category): string {
                    return $category->getName();
                },
                'placeholder' => 'Sélectionnez une catégorie',
                'required' => false,
            ])
            ->add('name')
            ->add('title')
            ->add('description')
            ->add('bannerPicture', FileType::class, [
                'mapped' => false,
                'label' => 'Bannière',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez selectionner un fichier de type jpeg,jpg,png de moins de 1024ko',
                    ]),
                ],
            ])
            ->add('mainPicture', FileType::class, [
                'mapped' => false,
                'label' => 'Image principale',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/jpg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Veuillez selectionner un fichier de type jpeg,jpg,png de moins de 1024ko',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
