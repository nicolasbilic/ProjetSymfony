<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class page404Controller extends AbstractController
{
    #[Route('/page-404', name: 'app_page-404')]
    public function index(): Response
    {
        return $this->render('page-404/page-404.html.twig', [
            'controller_name' => 'ItemController',
        ]);
    }
}
