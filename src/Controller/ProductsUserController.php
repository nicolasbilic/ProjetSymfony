<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;

class ProductsUserController extends AbstractController
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/products', name: 'app_products')]
    public function listProduct(): Response
    {
        $jsonData = $this->getJsonData('src/data/productsUserData.json');
        $data = json_decode($jsonData, true);
        return $this->render('productUser/productsUser.html.twig', [
            'data' => $data,
        ]);
    }

    //Method to get the data's Json
    private function getJsonData(string $path): string
    {
        $jsonFilePath = $this->kernel->getProjectDir() . '/' . $path;
        return file_get_contents($jsonFilePath);
    }
}
