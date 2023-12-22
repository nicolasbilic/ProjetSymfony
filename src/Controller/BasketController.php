<?php
// src/Controller/IndexController.php
namespace App\Controller;

use App\Entity\Product;
use App\Form\CartType;
use App\Services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class BasketController extends AbstractController
{

    public function displayBasket(UserManager $userManager, CartService $cartService, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CartType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            //Get user
            $user = $this->getUser();
            // Vérifiez si l'utilisateur est connecté
            if ($user) {
                $product = $em->getRepository(Product::class)->find(17);

                dump($product);

                $cartService->addProductToCart($user, $product, 1);
            }
        }

        $this->loadUserBasket($cartService);

        return $this->render(
            'basketUser/basket.html.twig',
            [
                'productList' => [
                    [
                        "picture" => "hache.png",
                        "name" => "Hache de combat pour truçidage zombien",
                        "price" => 179,
                        "quantity" => 1,

                    ], [
                        "picture" => "hache.png",
                        "name" => "Hache de combat pour truçidage zombien",
                        "price" => 179,
                        "quantity" => 1,
                    ],
                ],
                "totalePrice" => 388,
                'isLoggedIn' => $userManager->isLoggedIn,
            ]
        );
    }


    public function loadUserBasket(CartService $cartService): void
    {
        $user = $this->getUser(); // Je Récupère l'utilisateur connecté

        if ($user) { // Si l'utilisateur existe
            // J'utilise mon cartService pour vérifier s'il a un panier, si c'est le cas, je le récupère
            $cart = $cartService->getCartForUser($user);

            if ($cart === null) { // Si l'utilisateur n'a pas de panier, je crée un nouveau panier
                $cartService->createCartForUser($user);
                // $this->addFlash('success', 'Votre panier a été créé avec succès.');

                $this->redirectToRoute('homepage');
            }
        }
    }
}
