<?php
// src/Controller/IndexController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\UserManager;

class HeaderController extends AbstractController
{

    public function displayHeader(UserManager $userManager)
    {
        return $this->render(
            'header/header.html.twig',
            ['isLoggedIn' => $userManager->isLoggedIn,]
        );
    }
}
