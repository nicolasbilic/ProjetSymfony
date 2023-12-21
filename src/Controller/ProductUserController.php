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

    public function __construct(KernelInterface $kernel, ProductRepository $productRepos)
    {
        $this->kernel = $kernel;
        $this->productRepos = $productRepos;
    }

    #[Route('/product', name: 'app_product')]
    public function displayProduct(Request $request): Response
    {
        //Get the product id from the query
        $productId = $request->query->get('idProduct');
        $product = $this->getProduct($productId);
        dump($product);
        $jsonData = $this->getJsonData('src/data/productUserData.json');
        $data = json_decode($jsonData, true);
        return $this->render('productUser/productUser.html.twig', [
            'data' => $data,
            'product' => $product,
        ]);
    }
    private function getProduct($productId)
    {
        return $this->productRepos->findBy(['id' => $productId]);
    }
    //Method to get the data's Json
    private function getJsonData(string $path): string
    {
        $jsonFilePath = $this->kernel->getProjectDir() . '/' . $path;
        return file_get_contents($jsonFilePath);
    }
}
