<?php

namespace App\Controller;

use App\Entity\Review;
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
    // #[Route('list', name: 'app_reviews_manager')]
    // public function list(ReviewRepository $reviewRepo, Request $request, EntityManagerInterface $em): Response
    // {
    //     $reviews = $reviewRepo->findAll();
    //     $forms = [];

    //     foreach ($reviews as $review) {
    //         $form = $this->createForm(ReviewsManagerFormType::class, $review);
    //         $form->handleRequest($request);
    //         if ($form->isSubmitted() && $form->isValid()) {
    //             $updatedReview = $form->getData();
    //             $em->persist($updatedReview);
    //             $em->flush();
    //             // return $this->redirectToRoute('app_reviews_manager');
    //         }

    //         $forms[] = $form->createView();
    //     }

    //     return $this->render('reviews/listedit.html.twig', [
    //         'title' => 'Liste des avis',
    //         'forms' => $forms,
    //     ]);
    // }

    #[Route('list', name: 'app_reviews_manager')]
    public function list(ReviewRepository $reviewRepo, Request $request): Response
    {
        $reviews = $reviewRepo->findAll();
        $forms = array_map(
            fn (Review $review): FormView => $this->createForm(
                ReviewsManagerFormType::class,
                $review,
                ['action' => $this->generateUrl('app_review.save')]
            )->createView(),
            $reviews
        );

        return $this->render('reviews/listedit.html.twig', [
            'title' => 'Liste des avis',
            'forms' => $forms,
        ]);
    }

    #[Route('save', name: 'app_review.save')]
    public function save(ReviewRepository $reviewRepo, Request $request): Response
    {

        // assuming tha the `value` is the pk for a Review
        $reviewId = $request->request->get('value', -1);

        // this will only perform an update or cause an error.
        if (null === $review = $reviewRepo->find($reviewId)) {
            $this->addFlash('error', 'Unable to find Reivew to save!');
            return $this->redirectToRoute('app_reviews_manager');
        }

        $form = $this->createForm(ReviewsManagerFormType::class, $review);
        // this method will copy the form's data into the $review object, which is the one retrieved from the database
        // overwritting its original values. 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Assumes that the repostory class has a save method. Better than injecting the EntityManager!
            // The $review should be updated with the submitted data.
            $reviewRepo->save($review);
            $this->addFlash('success', 'Saved Reivew ' . $reviewId);
        } else {
            // should be a better message as to what failed.  
            $this->addFlash('warn', 'Unable to save Review ' . $reviewId);
        }

        return $this->redirectToRoute('app_reviews_manager');
    }
}
