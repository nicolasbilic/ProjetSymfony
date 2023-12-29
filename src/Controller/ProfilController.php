<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\UserManager;
use App\Entity\Admin;
use App\Entity\Customer;
use App\Form\ProfilForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/updateProfil', name: 'app_updateProfil')]
    public function updateProfil(UserManager $userManager, Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $hasher): Response
    {
        if (!$userManager->isConnected()) {
            return $this->redirectToRoute('app_login');
        }

        $user = $this->getUser();
        if ($user instanceof Admin) {
            return $this->redirectToRoute('app_admin_dashboard');
        }

        $form = $this->createForm(ProfilForm::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            if ($user instanceof Customer) {
                $user->setName($formData->getName());
                $user->setFirstName($formData->getFirstName());
                $user->setEmail($formData->getEmail());
                //Check if password exists and hash it
                $password = $formData->getPassword();
                if ($password) {
                    $hashedPassword = $hasher->hashPassword($user, $password);
                    $user->setPassword($hashedPassword);
                }
                $targetDirectory = 'img/profil/avatar/';
                $pictureFile = $formData->getPicture();
                $file = $form['picture']->getData();
                if ($file !== null) {
                    $fileName = $file->getClientOriginalName();
                    $file->move($targetDirectory, $fileName);
                    $user->setPicture($targetDirectory . $fileName);
                }
            }
            //Save modifications
            $entityManager->flush();
        }

        return $this->render('profil/profil.html.twig', [
            'userInfo' => $user,
            'form' => $form->createView(),
        ]);
    }
}
