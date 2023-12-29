<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Form\CartType;


class ProductUserController extends AbstractController
{
    private $productRepos;
    private $errors;

    public function __construct(ProductRepository $productRepos)
    {
        $this->productRepos = $productRepos;
        $this->errors;
    }

    #[Route('/product', name: 'app_product')]
    public function displayProduct(Request $request): Response
    {
        $form = $this->createForm(CartType::class);
        $form->handleRequest($request);

        //Get the product id from the query
        $productId = $request->query->get('idProduct');

        //Get product data from the database
        $product = $this->getProduct($productId);

        //Check if the product is found
        if (!$product) {
            $this->errors = "No product found.";
        }

        $categoryOfProduct = $product->getCategory(); // code que j'ai rajouté
        $parentCategory = $categoryOfProduct->getParent(); // code que j'ai rajouté

        return $this->render('productUser/productUser.html.twig', [
            'parentCategory' => $parentCategory, // code que j'ai rajouté
            'categoryOfProduct' => $categoryOfProduct, // code que j'ai rajouté
            'product' => $product,
            'errors' => $this->errors,
            'form' => $form->createView(),
        ]);
    }

    private function getProduct($productId)
    {
        return $this->productRepos->find($productId);
    }
}
