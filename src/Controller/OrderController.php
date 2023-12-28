<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Form\OrderFormType;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Customer;
use App\Entity\OrderState;

#[Route('admin/orders/')]
class OrderController extends AbstractController
{
    private $basketRepo;
    private $basketController;

    public function __construct(BasketRepository $basketRepo, BasketController $basketController)
    {
        $this->basketRepo = $basketRepo;
        $this->basketController = $basketController;
    }

    #[Route('list', name: 'app_admin_list_orders')]
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
}
