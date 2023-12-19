<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CustomerType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RegisterController extends AbstractController
{
    /* #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(): Response
    {
        return $this->render('register/index.html.twig', [
            'title' => 'S\'inscrire',
        ]);
    } */
    private UserPasswordHasherInterface $hasher;

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher)
    {
        $this->entityManager = $entityManager;
        $this->hasher = $hasher;
    }

    #[Route('/register', name: 'app_register', methods: ['GET', 'POST'])]
    public function register(Request $request): Response
    {
        $customer = new Customer();
        $form = $this->createForm(CustomerType::class, $customer);
        $form->handleRequest($request);
        /* $errors = $form->getErrors(true, false);
        dump($errors); */
        if ($form->isSubmitted() && $form->isValid()) {
            // dump($request->request->all());
            $hashPassword = $this->hasher->hashPassword(
                $customer,
                'password'
            );

            // Nicolas09!
            $customer->setPassword($hashPassword);

            // Récupérer le mot de passe saisi dans le formulaire
            /* $plainPassword = $form->get('password')->getData();

            // Hacher le mot de passe saisi
            $hashedPassword = $this->hasher->hashPassword($customer, $plainPassword);

            // Définir le mot de passe haché pour l'utilisateur
            $customer->setPassword($hashedPassword); */


            $this->entityManager->persist($customer);
            $this->entityManager->flush();

            // Optionally, add a flash message to indicate successful registration
            $this->addFlash('success', 'You have been successfully registered!');

            // Redirect to a different route after successful registration
            return $this->redirectToRoute('homepage');
        } /* else {
            // Récupérer les erreurs du formulaire pour le débogage
            $errors = $form->getErrors(true, false);
            dump($errors);
        } */

        return $this->render('register/index.html.twig', [
            'title' => 'S\'inscrire',
            'form' => $form->createView(),
        ]);
    }
}