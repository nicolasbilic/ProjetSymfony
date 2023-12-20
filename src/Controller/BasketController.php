<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\UserManager;
use Symfony\Component\HttpFoundation\Response;

class BasketController extends AbstractController
{

    public function displayBasket(UserManager $userManager): Response
    {
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
}
