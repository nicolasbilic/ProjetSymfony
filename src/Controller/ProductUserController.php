<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Repository\ProductRepository;

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
    public function displayProduct(Request $request): Response
    {
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
