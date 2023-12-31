<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Order;
use App\Form\OrderFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;


#[Route('admin/orders/')]
class OrderController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('list', name: 'app_admin_list_orders')]
    public function list(OrderRepository $orderRepo, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        $orders = $orderRepo->findAll();

        return $this->render('orders/listedit.html.twig', [
            'title' => 'Liste des commandes',
            'orders' => $orders,
        ]);
    }

    #[Route('update/{id}', name: 'app_update_order')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Order $order,
    ) {
        if ($order === null) {
            return $this->redirectToRoute('app_admin_list_orders');
        }

        $form = $this->createForm(OrderFormType::class, $order);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($order);
            $em->flush();
            return $this->redirectToRoute('app_admin_list_orders');
        }
        return $this->render('orders/update.html.twig', [
            'title' => 'Mise à jour de la commande',
            'form' => $form,
        ]);
    }
}
