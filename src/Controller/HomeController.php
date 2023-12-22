<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class HomeController extends AbstractController
{
    private $slides;
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        //Get slides pictures
        $this->getSlides();
        //Get index data from Json
        $jsonData = $this->getJsonData('src/data/homeData.json');
        $data = json_decode($jsonData, true);
        //Get new product to show
        $newProductDatas = $this->getNewProducts($entityManager);
        return $this->render('home.html.twig', [
            'slideShowPictures' => $this->slides,
            'data' => $data,
            'newProductsDatas' => $newProductDatas,
        ]);
    }

    public function getNewProducts(EntityManagerInterface $entityManager)
    {
        //Get line by dateAdd then keep 6 of them
        $newProductsData = $entityManager->getRepository(Product::class)
            ->createQueryBuilder('p')
            ->select(['p.id', 'p.name', 'p.price', 'p.dateAdd as createdAt', 'p.picture', 'p.description'])
            ->orderBy('p.dateAdd', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getArrayResult();
        return $newProductsData;
    }


    public function getSlides()
    {
        // Path of the slideshow directory
        $directoryPath = $this->kernel->getProjectDir() . '/public/images/bannerSlideshow';

        // Get the files in the directory
        $files = scandir($directoryPath);
        $jpgFiles = [];

        foreach ($files as $file) {
            // Exclude "." and ".."
            if ($file !== "." && $file !== "..") {
                // Check if the file is a jpg
                if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                    //Store the file in the array
                    $jpgFiles[] = $file;
                }
            }
        }

        $this->slides = $jpgFiles;

        return $jpgFiles;
    }

    //Method to get the data's Json
    private function getJsonData(string $path): string
    {
        $jsonFilePath = $this->kernel->getProjectDir() . '/' . $path;
        return file_get_contents($jsonFilePath);
    }
}
