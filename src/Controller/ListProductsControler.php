<?php

// src/Controller/ListProductsController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;

class ListProductsController extends AbstractController
{
    private $kernel;
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/list-products', name: 'list_products')]
    public function listProduct(): Response
    {
        //Get index data from Json
        $jsonData = $this->getJsonData('src/data/listProductsData.json');
        $data = json_decode($jsonData, true);

        return $this->render('listProducts.html.twig', [
            'data' => $data,
        ]);
    }

    // Fonction pour récupérer les données depuis un fichier JSON
    private function getJsonData(string $path): string
    {
        $jsonFilePath = $this->kernel->getProjectDir() . '/' . $path;
        return file_get_contents($jsonFilePath);
    }
}
