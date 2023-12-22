<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Repository\ProductRepository;
use App\Services\CartService;
use App\Form\CartType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class ProductUserController extends AbstractController
{
    private $kernel;
    private $productRepos;
    private $errors;

    public function __construct(KernelInterface $kernel, ProductRepository $productRepos)
    {
        $this->kernel = $kernel;
        $this->productRepos = $productRepos;
        $this->errors;
    }

    #[Route('/product', name: 'app_product')]
    public function displayProduct(CartService $cartService, EntityManagerInterface $em, Request $request): Response
    {
        $form = $this->createForm(CartType::class);
        $form->handleRequest($request);
        $user = $this->getUser();
        dump($user);

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

        // Get the product id from the query
        $productId = $request->query->get('idProduct');

        // Get product data from the database
        $product = $this->getProduct($productId);

        // Check if the product is found
        if (!$product) {
            $this->errors = "No product found.";
        }

        // Get additional data from the JSON file
        $jsonData = $this->getJsonData('src/data/productUserData.json');
        $data = json_decode($jsonData, true);

        return $this->render('productUser/productUser.html.twig', [
            'data' => $data,
            'product' => $product,
            'errors' => $this->errors,
            'form' => $form->createView(),
        ]);
    }

    private function getProduct($productId)
    {
        return $this->productRepos->find($productId);
    }

    //Method to get the data's JSON
    private function getJsonData(string $path): string
    {
        $jsonFilePath = $this->kernel->getProjectDir() . '/' . $path;

        //Check if the JSON file exists
        if (!file_exists($jsonFilePath)) {
            $this->errors[] = "JSON file not found at '{$jsonFilePath}'.";
            return '';
        }

        return file_get_contents($jsonFilePath);
    }
}
