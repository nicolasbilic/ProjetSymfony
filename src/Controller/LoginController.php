<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        //Récupérer les erreurs de connexion
        $error = $authenticationUtils->getLastAuthenticationError();
        //Récupérer le nom de l'utilisateur s'il existe
        $username = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'title' => 'Login',
            'username' => $username,
            'error' => $error,
        ]);
    }
}
