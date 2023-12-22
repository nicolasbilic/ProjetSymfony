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
    private $errors;

    public function __construct(CategoryRepository $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
        $this->errors;
    }

    #[Route('/list-products', name: 'app_list_products_user')]
    public function listProduct(Request $request): Response
    {
        //Get the main category (heal / weapon / close) from the query
        $categoryName = $request->query->get('category');

        //If no query, set a default category
        if (!$categoryName) {
            $categoryName = "armements";
        }

        //Get the category and subCategory data from the database
        $category = $this->getCategory($categoryName);

        //Check if the main category is found
        if (!$category) {
            $this->errors[] = "There is no category named '{$categoryName}' found.";
        }

        //Get subcategories only if the main category is found
        $subCategories = [];
        if ($category) {
            $subCategories = $this->getSubCategory($categoryName);

            //Check if subcategories are found
            if (empty($subCategories)) {
                $this->errors = "There are no subcategories found for '{$categoryName}'.";
            }
        }

        //Proceed only if the main category and subcategories are found
        if ($category && $subCategories) {
            //Get all products from subcategories
            $allProducts = $this->getAllProducts($subCategories);
        } else {
            $allProducts = [];
        }

        return $this->render('productUser/listProducts.html.twig', [
            'selectedCategory' => $category,
            'subCategories' => $subCategories,
            'allProducts' => $allProducts,
            'errors' => $this->errors,
        ]);
    }

    private function getCategory($categoryName)
    {
        return $this->categoryRepo->findOneBy(['name' => $categoryName]);
    }

    private function getSubCategory($categoryName)
    {
        $category = $this->getCategory($categoryName);

        // Check if the main category is found before getting subcategories
        if ($category) {
            $parentId = $category->getId();
            return $this->categoryRepo->findBy(['parent' => $parentId]);
        }

        return [];
    }

    private function getAllProducts($subCategories)
    {
        $products = [];
        foreach ($subCategories as $subCategory) {
            $categoryId = $subCategory->getId();
            $categoryProducts = $this->categoryRepo->find($categoryId)->getProducts();

            // Check if category products are found before merging
            if ($categoryProducts) {
                $products = array_merge($products, $categoryProducts->getValues());
            } else {
                $this->errors = "No products found for subcategory '{$subCategory->getName()}'.";
            }
        }
        return $products;
    }
}
