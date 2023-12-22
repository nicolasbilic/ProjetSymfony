<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('admin/products/')]
class ProductsController extends AbstractController
{
    #[Route('list', name: 'app_list_products')]
    public function displayList(ProductRepository $productRepo, Request $request): Response
    {
        $products = $productRepo->findAll();

        return $this->render('products/list.html.twig', [
            'title' => 'Liste des produits',
            'products' => $products,
        ]);
    }
}
