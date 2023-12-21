<?php
// src/Controller/IndexController.php
namespace App\Controller;

use App\Services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BasketController extends AbstractController
{

    public function displayBasket(CartService $cartService)
    {

        $this->loadUserBasket($cartService);

        return $this->render(
            'basket.html.twig',
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
