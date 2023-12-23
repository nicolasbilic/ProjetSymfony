<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Services\CartService;
use App\Form\CartType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

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
    public function displayListProducts(CartService $cartService, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(CartType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        //dump($user);

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

        //Get the subcategory id from the query
        $subcategoryId = $request->query->get('category');
        //If no query, set a default subcategory id
        if (!$subcategoryId) {
            $subcategoryId = 4;
        }
        //Get subcategory and products data from the database
        $subcategory = $this->getSubcategory($subcategoryId);
        $products = $this->getSubcategoryProducts($subcategoryId);

        $categoryOfSubcategory = $subcategory->getParent(); // code que j'ai rajouté

        return $this->render('productUser/productsUser.html.twig', [
            'categoryOfSubcategory' => $categoryOfSubcategory, // code que j'ai rajouté
            'subcategory' => $subcategory,
            'products' => $products,
            'errors' => $this->errors,
            'form' => $form->createView(),
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
