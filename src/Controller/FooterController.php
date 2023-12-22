<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\UserManager;

class FooterController extends AbstractController
{

    public function displayFooter(UserManager $userManager)
    {
        return $this->render(
            'footer/footer.html.twig',
            ['isLoggedIn' => $userManager->isLoggedIn,]
        );
    }
}
