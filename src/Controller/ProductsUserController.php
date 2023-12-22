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
    private $errors;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->errors;
    }

    #[Route('/products', name: 'app_products')]
    public function displayListProducts(Request $request): Response
    {
        //Get the subcategory id from the query
        $subcategoryId = $request->query->get('category');
        //If no query, set a default subcategory id
        if (!$subcategoryId) {
            $subcategoryId = 4;
        }
        //Get subcategory and products data from the database
        $subcategory = $this->getSubcategory($subcategoryId);
        $products = $this->getSubcategoryProducts($subcategoryId);

        return $this->render('productUser/productsUser.html.twig', [
            'subcategory' => $subcategory,
            'products' => $products,
            'errors' => $this->errors,
        ]);
    }

    private function getSubcategory($subcategoryId)
    {
        $subcategory = $this->categoryRepo->find($subcategoryId);

        //Check if the subcategory is found
        if (!$subcategory) {
            $this->errors = "No subcategory found.";
        }

        return $subcategory;
    }

    private function getSubcategoryProducts($subcategoryId)
    {
        $products = [];
        $subcategory = $this->getSubcategory($subcategoryId);

        //Proceed only if the subcategory is found
        if ($subcategory) {
            $categoryProducts = $subcategory->getProducts();

            // heck if category products are found before merging
            if ($categoryProducts->count() > 0) {
                $products = $categoryProducts->getValues();
            } else {
                $this->errors = "No products found for subcategory '{$subcategory->getName()}'.";
            }
        }

        return $products;
    }
}
