<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Entity\Basket;
use App\Entity\Customer;
use Doctrine\ORM\EntityManagerInterface;

class ProductsUserController extends AbstractController
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/products', name: 'app_products')]
    public function listProduct(EntityManagerInterface $em, Customer $customer): Response
    {
        $jsonData = $this->getJsonData('src/data/productsUserData.json');
        $data = json_decode($jsonData, true);
        return $this->render('productUser/productsUser.html.twig', [
            'data' => $data,
            '_dump' => $customer,
        ]);
    }

    //Method to get the data's Json
    private function getJsonData(string $path): string
    {
        $jsonFilePath = $this->kernel->getProjectDir() . '/' . $path;
        return file_get_contents($jsonFilePath);
    }
}
