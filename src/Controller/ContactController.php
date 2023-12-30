<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Customer;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer, Customer $customer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $titleValue = $form->get('title')->getData();
            if (!$titleValue) {
                $this->redirectToRoute('contact');
            } else if ($titleValue === 1) { //Contact us
                $message = $form->get('message')->getData();
                $firstName = $form->get('firstName')->getData();
                $lastName = $form->get('lastName')->getData();
                $email = $form->get('email')->getData();
                $subject = "Contact NecroStore client : $firstName $lastName";
                $emailBody = $message;
                //Create the mail object
                $email = (new Email())
                    ->from($email)
                    ->to('contact@necrostore.net')
                    ->subject($subject)
                    ->text($emailBody);
                $mailer->send($email);
            } else if ($titleValue === 2) { //Let a review
                $reviewData = $form->getData();
                $user = $this->getUser();
                $userId = ($user instanceof Customer) ? $user->getId() : null;
                //Create the object review
                $review = new Review();
                $review
                    ->setTitle("Laisser un avis")
                    ->setResume($reviewData['message'])
                    ->setValue($reviewData['value'])
                    ->setState('pending')
                    ->setDateReview(new \DateTimeImmutable())
                    ->setUserFirstName($form->get('firstName')->getData())
                    ->setUserLastName($form->get('lastName')->getData())
                    ->setUserId($userId);
                $entityManager->persist($review);
                $entityManager->flush();
            }
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
