<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\OrderRepository;
use App\Repository\CustomerRepository;
use App\Repository\BasketRepository;
use \Symfony\Bundle\SecurityBundle\Security;

class AdminController extends AbstractController
{
    private $orderRepo;
    private $customerRepo;
    private $basketRepo;
    private $security;

    public function __construct(OrderRepository $orderRepo, CustomerRepository $customerRepo, BasketRepository $basketRepo, Security $security)
    {
        $this->orderRepo = $orderRepo;
        $this->customerRepo = $customerRepo;
        $this->basketRepo = $basketRepo;
        $this->security = $security;
    }

    #[Route(path: '/admin', name: 'app_admin_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: '/admin/logout', name: 'app_admin_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route(path: '/admin/dashboard', name: 'app_admin_dashboard')]
    public function dashboard(): Response
    {
        $totalSales = $this->orderRepo->findTotalSales();
        $totalOrders = $this->orderRepo->findNumberOfOrders();
        $totalCustomers = $this->customerRepo->findNumberOfCustomers();
        $totalBaskets = $this->basketRepo->findNumberOfBaskets();
        $percBasketValidated = $totalOrders / $totalBaskets * 100;
        $percBasketValidated = round($percBasketValidated, 2);
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        return $this->render('admin/dashboard.html.twig', [
            'totalSales' => $totalSales,
            'totalOrders' => $totalOrders,
            'totalCustomers' => $totalCustomers,
            'totalBaskets' => $totalBaskets,
            'percentValidatedBasket' => $percBasketValidated,
        ]);
    }
}
