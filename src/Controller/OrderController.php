<?php

namespace App\Controller;

use App\Entity\Admin;
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
        $forms = [];

        foreach ($orders as $order) {
            $form = $this->createForm(OrderFormType::class, $order);
            $forms[] = $form->createView();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $order = $form->getData();
                $em->persist($order);
                $em->flush();

                return $this->redirectToRoute('app_admin_list_orders');
            }
        }

        return $this->render('orders/listedit.html.twig', [
            'title' => 'Liste des commandes',
            'forms' => $forms,
        ]);
    }
}
