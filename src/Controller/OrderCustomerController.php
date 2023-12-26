<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\Basket;
use App\Entity\Order;
use App\Entity\OrderLine;
use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Customer;
use App\Entity\OrderState;
use App\Form\ValidateOrderFormType;
use App\Services\CartService;

#[Route('customer/orders/')]
class OrderCustomerController extends AbstractController
{
    private $basketRepo;
    private $basketController;

    public function __construct(BasketRepository $basketRepo, BasketController $basketController)
    {
        $this->basketRepo = $basketRepo;
        $this->basketController = $basketController;
    }

    #[Route('new', name: 'app_new_order')]
    public function create(OrderRepository $orderRepo, Request $request, EntityManagerInterface $em, CartService $cartService): Response
    {
        $orderId = 0;
        $customer = $this->getUser();
        $order = new Order();
        $basket = $cartService->getCartForUser($customer);
        $basketlines = $basket->getBasketLine(); // basketlines retourne array vide...
        $address = new Address();
        if ($customer instanceof Customer) {
            $address = $customer->getAddress();
        }
        dump($basket);
        dump($basketlines);
        $products = $cartService->getCartList();
        $totalBasket = $cartService->calculateBasketTotal($products);
        $waitingPaymentState = $em->getRepository(OrderState::class)->find(1);

        if ($address === null) {
            return $this->redirectToRoute('app_new_address');
        }

        if ($basket === null) {
            return $this->redirectToRoute('app_index');
        }

        $today = new \DateTimeImmutable();

        if ($request->isMethod('POST')) {
            if ($request->request->has('validate')) {
                $order->setShippingPrice(0);
                $order->setShippingAddress($address);
                $order->setInvoiceAddress($address);
                $order->setOrderState($waitingPaymentState);
                $order->setTotal($totalBasket);
                $order->setDate($today);
                $order->setBasket($basket);
                $order->setCustomer($customer);
                dump('create');
                $em->persist($order);
                $em->flush();
                $orderId = $order->getId();


                foreach ($basketlines as $basketline) {
                    $product = $basketline->getProduct();
                    $orderLine = new OrderLine();
                    $orderLine->setProductName($product->getName());
                    $quantity = $basketline->getQuantity();
                    $orderLine->setQuantity($basketline->getQuantity());
                    $price = $product->getPrice();
                    $orderLine->setPrice($price);
                    $tva = $product->getTva();
                    $orderLine->setTva(1); // a modifier !!!!
                    $orderLine->setDiscount($product->getDiscount());
                    $orderLine->setTotal($price * $quantity);
                    $orderLine->setOrderCustomer($order);
                    $em->persist($orderLine);
                    $em->flush();
                }
                // Création d'un nouveau basket, le précédent a été "transformé en commande"
                $basket = new Basket();
                $basket->setCustomer($customer);
                $em->persist($basket);
                $em->flush();
                return $this->redirectToRoute('app_show_order', ['id' => $orderId]);
            }
        }

        return $this->render('orders/new.html.twig', [
            'customer' => $customer,
            'title' => 'Validation de la commande',
            'basket' => $basket,
            'basketTotal' => $totalBasket,
            'basketLines' => $basketlines,
            'address' => $address,
        ]);
    }


    #[Route('list', name: 'app_list_orders')]
    public function displayList(Request $request): Response
    {

        $customer = $this->getUser();
        $orders = [];
        if ($customer instanceof Customer) {
            $orders = $customer->getOrderCustomer();
        }

        return $this->render('orders/CustomerOrderlist.html.twig', [
            'title' => 'Vos commandes',
            'orders' => $orders,
        ]);
    }

    #[Route('details/{id}', name: 'app_show_order')]
    public function displayOrder(Request $request, ?Order $order): Response
    {
        $customer = $this->getUser();
        $orderLines = $order->getOrderLine();
        if ($order === null) {
            return $this->redirectToRoute('app_list_orders');
        }
        if ($customer instanceof Customer) {
            $orders = $customer->getOrderCustomer();
            if ($order->getCustomer() != $customer) {
                return $this->redirectToRoute('app_list_orders');
            }
        }


        return $this->render('orders/details.html.twig', [
            'title' => 'Votre commande',
            'order' => $order,
            'orderLines' => $orderLines,
        ]);
    }
}
