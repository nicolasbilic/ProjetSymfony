<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Basket;
use App\Entity\Customer;
use App\Entity\Order;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\OrderState;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class OrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $today = new \DateTime();
        $builder
            ->add('orderState', EntityType::class, [
                'class' => OrderState::class,
                'label' => false,
                'choice_label' => function (OrderState $orderState): string {
                    return $orderState->getLabel();
                }
            ])
            ->add('basket', EntityType::class, [
                'class' => Basket::class,
                // 'attr' => ['style' => 'display: none;'],
                // 'label' => false,
                'choice_label' => function (Basket $basket): string {
                    return $basket->getId();
                }

            ])
            ->add('shippingAddress', EntityType::class, [
                'class' => Address::class,
                // 'attr' => ['style' => 'display: none;'],
                // 'label' => false,
                'choice_label' => function (Address $address): string {
                    return $address->getId();
                }
            ])
            ->add('invoiceAddress', EntityType::class, [
                'class' => Address::class,
                // 'attr' => ['style' => 'display: none;'],
                // 'label' => false,
                'choice_label' => function (Address $address): string {
                    return $address->getId();
                }
            ])
            ->add('date', DateTimeType::class, [
                'widget' => 'single_text',
                'input'  => 'datetime_immutable',
                'required' => false,
            ])

            ->add('total', null, [
                'attr' => ['style' => 'display: none;'],
                'label' => false,
            ])
            ->add('customer', EntityType::class, [
                'class' => Customer::class,
                // 'attr' => ['style' => 'display: none;'],
                // 'label' => false,
                'choice_label' => function (Customer $customer): string {
                    return $customer->getName();
                }
            ])
            ->add('shippingPrice', null, [
                // 'attr' => ['style' => 'display: none;'],
                // 'label' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
