<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Services\UserManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils, UserManager $userManager): Response
    {
        if ($userManager->isLoggedIn === true) {
            return $this->redirectToRoute('homepage');
        }
        //Récupérer les erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        //Récupérer le nom de l'utilisateur s'il existe
        $username = $authenticationUtils->getLastUsername();
        // Si la connexion est réussie, ajouter une variable à la session
        return $this->render('login/index.html.twig', [
            'title' => 'Se connecter',
            'username' => $username,
            'error' => $error,
        ]);

        // public function login(Request $request, UserPasswordHasherInterface $passwordHasher)
        /* {
            // ...        if ($passwordHasher->isPasswordValid($user, $submittedPassword)) {
                // Connexion réussie        } else {
                // Mot de passe incorrect
            }
            // ...
        } */
    }
}
