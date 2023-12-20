<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BasketController extends AbstractController
{

    public function displayBasket()
    {
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
}
