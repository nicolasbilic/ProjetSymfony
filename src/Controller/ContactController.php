<?php 

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('contact', name: 'app_contact')]
class ContactController extends AbstractController
{
    #[Route('/', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact.html.twig', [
            
        ]);
    }
}