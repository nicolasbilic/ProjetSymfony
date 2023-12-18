<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;


class FooterController extends AbstractController
{
    public function renderFooter(): Response
    {
        return $this->render('partials/footer.html.twig');
    }
}
