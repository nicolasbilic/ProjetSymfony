<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;
use App\Form\ReviewFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReviewRepository;

#[Route('/reviews/')]
class ReviewController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('list', name: 'app_list_reviews')]
    public function displayList(ReviewRepository $reviewRepo, Request $request): Response
    {
        $reviews = $reviewRepo->findApprovedReviews();
        $customer = $this->getUser();
        $isLogged = $customer !== null ? true : false;

        return $this->render('reviews/list.html.twig', [
            'title' => 'Avis clients',
            'reviews' => $reviews,
            'isLogged' => $isLogged,
        ]);
    }

    #[Route('new', name: 'app_new_review')]
    public function new(EntityManagerInterface $em, Request $request, ReviewRepository $reviewRepository): Response
    {
        $review = new Review();
        $form = $this->createForm(ReviewFormType::class, $review);
        $form->handleRequest($request);
        $customer = $this->getUser();

        if (!$customer instanceof Customer) {
            return $this->redirectToRoute('app_list_reviews');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('app_list_reviews');
        }
        return $this->render('reviews/new.html.twig', [
            'title' => 'Ajout d\'un avis',
            'form' => $form,
        ]);
    }
}
