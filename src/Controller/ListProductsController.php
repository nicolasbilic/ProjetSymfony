<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;

class ListProductsController extends AbstractController
{
    private $categoryRepo;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    #[Route('/list-products', name: 'app_list_products_user')]
    public function listProduct(Request $request): Response
    {
        //Get the main category (heal / weapon / close) from the query
        $categoryName = $request->query->get('category');
        //Get the category and subCategory data from the bdd
        $category = $this->getCategory($categoryName);
        $subCategories = $this->getSubCategory($categoryName);
        //Get all products from subCategory
        $allProducts = $this->getAllProducts($subCategories);

        return $this->render('productUser/listProducts.html.twig', [
            'selectedCategory' => $category,
            'subCategories' => $subCategories,
            'allProducts' => $allProducts,
        ]);
    }

    private function getCategory($categoryName)
    {
        return $this->categoryRepo->findOneBy(['name' => $categoryName]);
    }

    private function getSubCategory($categoryName)
    {
        $parentId = $this->getCategory($categoryName)->getId();
        return $this->categoryRepo->findBy(['parent' => $parentId]);
    }

    private function getAllProducts($subCategories)
    {
        $products = [];
        foreach ($subCategories as $subCategory) {
            $categoryId = $subCategory->getId();
            $categoryProducts = $this->categoryRepo->find($categoryId)->getProducts();
            $products = array_merge($products, $categoryProducts->toArray());
        }
        return $products;
    }
}
