<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class HeaderController extends AbstractController
{
    public function renderHeader(): Response
    {
        return $this->render('partials/header.html.twig');
    }
}
