<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class ProductsUserController extends AbstractController
{
    private $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    #[Route('/products', name: 'app_products')]
    public function displayListProducts(Request $request): Response
    {
        //Get the subcategory id from the query
        $subcategoryId = $request->query->get('category');
        $subcategory = $this->getSubcategory($subcategoryId);
        $products = $this->getSubcategoryProducts($subcategoryId);

        return $this->render('productUser/productsUser.html.twig', [
            'subcategory' => $subcategory,
            'products' => $products,
        ]);
    }

    private function getSubCategory($subcategoryId)
    {
        return $this->categoryRepo->findBy(['id' => $subcategoryId]);
    }

    private function getSubcategoryProducts($subcategoryId)
    {
        $products = [];
        $categoryProducts = $this->categoryRepo->find($subcategoryId)->getProducts();
        $products = array_merge($products, $categoryProducts->toArray());
        return $products;
    }
}
