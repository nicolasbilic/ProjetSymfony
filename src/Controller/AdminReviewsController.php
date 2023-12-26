<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;
use App\Form\ReviewFormType;
use App\Form\ReviewsManagerFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReviewRepository;

#[Route('/admin/reviews/')]
class AdminReviewsController extends AbstractController
{
    public function __construct()
    {
    }

    #[Route('list', name: 'app_reviews_manager')]
    public function list(ReviewRepository $reviewRepo, Request $request, EntityManagerInterface $em): Response
    {
        $reviews = $reviewRepo->findAll();
        $forms = [];

        foreach ($reviews as $review) {
            $form = $this->createForm(ReviewsManagerFormType::class, $review);
            $forms[] = $form->createView();

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $order = $form->getData();
                $em->persist($order);
                $em->flush();

                return $this->redirectToRoute('app_reviews_manager');
            }
        }

        return $this->render('reviews/listedit.html.twig', [
            'title' => 'Liste des avis',
            'forms' => $forms,
        ]);
    }
}
