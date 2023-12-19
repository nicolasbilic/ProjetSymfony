<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        echo 'toto';
        var_dump(password_verify('Nicolas12!',  '$2y$13$bLYmonMc4Wn8CdPpM7u8COwIK9Lk8SufXFWBWWyH9H4tOqfChLkX6'));
        //Récupérer les erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        //Récupérer le nom de l'utilisateur s'il existe
        $username = $authenticationUtils->getLastUsername();

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
