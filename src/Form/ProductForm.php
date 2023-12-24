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
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\File;
use App\Controller\CategoryController;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;

class ProductFormType extends AbstractType
{
    // protected $categoryController;

    // public function __construct(CategoryController $categoryController)
    // {
    //     $this->categoryController = $categoryController;
    // }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $today = new \DateTime();
        // $categories = $this->categoryController->getCategoriesWithoutChild();
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('c1')
                        ->leftJoin('App\Entity\Category', 'c2', 'WITH', 'c1.id = c2.parent')
                        ->andWhere('c2.id IS NULL')
                        ->orderBy('c1.id', 'ASC');
                },
                'choice_label' => 'name',
                /* 'attr' => [
                    'class' => 'btn btn-primary',
                ], */
            ])
            ->add('name')
            ->add('price', null, [
                'attr' => [
                    'style' => 'text-align:center;',
                    'class' => 'inputright',
                ]
            ])
            ->add('description')
            ->add('discount', null, [
                'attr' => [
                    'style' => 'text-align:center;',
                ]
            ])
            ->add('tva', EntityType::class, [
                'class' => Tva::class,
                'choice_label' => function (Tva $tva): string {
                    return $tva->getValue() . '%';
                }
            ])
            ->add('stock', null, [
                'data' => 1,
            ])
            ->add('dateAdd', DateType::class, [
                'data' => $today,
                'label' => false,
                'attr' => [
                    'style' => 'display:none;',
                ]
            ])
            ->add('file', FileType::class, [
                'mapped' => false,
                'label' => 'Choisir',
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
            'data_class' => Product::class,
        ]);
    }
}
