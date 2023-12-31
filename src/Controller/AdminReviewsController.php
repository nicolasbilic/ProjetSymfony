<?php

namespace App\Controller;

use App\Entity\Review;
use App\Form\ReviewFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ReviewsManagerFormType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReviewRepository;
use Symfony\Component\Form\FormView;

#[Route('/admin/reviews/')]
class AdminReviewsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('list', name: 'app_reviews_manager')]
    public function list(ReviewRepository $reviewRepo, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        $reviews = $reviewRepo->findAll();

        return $this->render('reviews/listedit.html.twig', [
            'title' => 'Liste des avis',
            'reviews' => $reviews,
        ]);
    }

    #[Route('update/{id}', name: 'app_update_review')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Review $review,
    ) {
        if ($review === null) {
            return $this->redirectToRoute('app_reviews_manager');
        }

        $form = $this->createForm(ReviewsManagerFormType::class, $review);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($review);
            $em->flush();
            return $this->redirectToRoute('app_reviews_manager');
        }
        return $this->render('reviews/update.html.twig', [
            'title' => 'Mise à jour de l\'avis',
            'form' => $form,
        ]);
    }
}
