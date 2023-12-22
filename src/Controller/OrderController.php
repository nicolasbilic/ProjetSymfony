<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use Symfony\Component\HttpFoundation\Request;


#[Route('admin/orders/')]
class OrderController extends AbstractController
{
    #[Route('list', name: 'app_list_orders')]
    public function list(OrderRepository $orderRepo, Request $request): Response
    {
        $orders = $orderRepo->findAll();

        return $this->render('orders/list.html.twig', [
            'title' => 'Liste des commandes',
            'orders' => $orders,
        ]);
    }
}
