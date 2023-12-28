<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Customer;
use App\Form\AddressFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\AddressRepository;



#[Route('customer/address/')]
class AddressController extends AbstractController
{

    public function __construct()
    {
    }


    #[Route('new', name: 'app_new_address')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressFormType::class, $address);
        $form->handleRequest($request);
        $customer = $this->getUser();

        if (!($customer instanceof Customer)) {
            return $this->redirectToRoute('app_index');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($address);
            if ($customer instanceof Customer) {
                $customer->setAddress($address);
                $em->persist($customer);
            }
            $em->flush();
            return $this->redirectToRoute('app_new_order');
        }
        return $this->render('address/new.html.twig', [
            'title' => 'Créer / Modifier votre adresse',
            'form' => $form,
        ]);
    }
}
