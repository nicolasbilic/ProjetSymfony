<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


#[Route('admin/orders/')]
class OrderController extends AbstractController
{
    #[Route('list', name: 'app_list_orders')]
    public function list(OrderRepository $orderRepo, Request $request, EntityManagerInterface $em): Response
    {
        $orders = $orderRepo->findAll();
        $forms = [];

        foreach ($orders as $order) {
            $form = $this->createForm(OrderFormType::class, $order);
            $forms[] = $form->createView();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $order = $form->getData();
                $em->persist($order);
                $em->flush();

                return $this->redirectToRoute('app_list_orders');
            }
        }

        return $this->render('orders/listedit.html.twig', [
            'title' => 'Liste des commandes',
            'forms' => $forms,
        ]);
    }

    // #[Route('list', name: 'app_list_orders')]
    // public function list(OrderRepository $orderRepo, Request $request, EntityManagerInterface $em): Response
    // {
    //     $orders = $orderRepo->findAll();

    //     return $this->render('orders/listnoedit.html.twig', [
    //         'title' => 'Liste des commandes',
    //         'orders' => $orders,
    //     ]);
    // }

    #[Route('update/{id}', name: 'app_update_order')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Order $order,
    ) {
        if ($order === null) {
            return $this->redirectToRoute('app_list_orders');
        }

        $form = $this->createForm(OrderFormType::class, $order);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($order);
            $em->persist($order);
            $em->flush();
        }
        return $this->render('orders/update.html.twig', [
            'title' => 'Mise à jour de la commande',
            'form' => $form,
            'order' => $order,
        ]);
    }
}
