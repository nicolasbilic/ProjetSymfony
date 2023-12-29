<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OrderRepository;
use App\Repository\ReviewRepository;
use Doctrine\Persistence\ManagerRegistry;

class HomeController extends AbstractController
{
    private $slides;
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager, OrderRepository  $orderRepository, ReviewRepository $reviewRepo, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        if ($user) {
            if ($user instanceof Admin) {
                return $this->redirectToRoute('app_admin_dashboard');
            }
        }
        //Get slides pictures
        $this->getSlides();
        $bestSales = $orderRepository->getBestSales();
        //Get new product to show
        $newProductDatas = $this->getNewProducts($entityManager);
        $reviews = $this->getReviews($reviewRepo);
        $pictureReviews = [];
        foreach ($reviews as $review) {
            $userId = $review->getUserId();
            if ($userId) {
                // Utilisez le gestionnaire de doctrine pour récupérer l'utilisateur
                $user =  $doctrine->getRepository(Customer::class)->find($userId);
                $pictureReviews[] = $user->getPicture();
            }
        }
        dump($pictureReviews);
        return $this->render('home.html.twig', [
            'slideShowPictures' => $this->slides,
            'bestSales' => $bestSales,
            'newProductsDatas' => $newProductDatas,
            'reviews' => $reviews,
            'reviewsPic' => $pictureReviews
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
        $directoryPath = $this->kernel->getProjectDir() . '/public/img/bannerSlideshow';
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

    public function getReviews(ReviewRepository $reviewRepo)
    {
        $reviews = $reviewRepo->findBy(
            ['state' => 'approved'],
            ['date_review' => 'DESC'],
            4
        );
        return $reviews;
    }
}
