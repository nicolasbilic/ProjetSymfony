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
    private $errors;
    public function __construct()
    {
        $this->errors = [];
    }

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
            if ($user instanceof Customer) {
                $formData = $form->getData();
                $password = $form->get('password')->getData();
                $user->setName($formData->getName());
                $user->setFirstName($formData->getFirstName());
                $user->setEmail($formData->getEmail());
                if ($password !== null) {
                    if ($this->validatePassword($password) === true) {
                        $hashedPassword = $hasher->hashPassword($user, $password);
                        $user->setPassword($hashedPassword);
                    }
                }
                $targetDirectory = 'img/profil/avatar/';
                $file = $form['picture']->getData();
                if ($file !== null) {
                    //Check if repertoy exist, if not, create it
                    if (!is_dir($targetDirectory)) {
                        mkdir($targetDirectory, 0755, true);
                    }
                    //Rename and move avatarFile
                    $fileName = $file->getClientOriginalName();
                    $file->move($targetDirectory, $fileName);
                    $user->setPicture($targetDirectory . $fileName);
                }
                //Save modifications
                $entityManager->flush();
            }
        }

        return $this->render('profil/profil.html.twig', [
            'userInfo' => $user,
            'errors' => $this->errors,
            'form' => $form->createView(),
        ]);
    }

    private function validatePassword($password)
    {
        $passwordIsValid = false;
        //Check the length of the password
        if (strlen($password) < 8) {
            $this->errors[] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
        //Check a minimum of one upperCase in the password
        if (!preg_match('/[A-Z]/', $password)) {
            $this->errors[] = "Le mot de passe doit contenir au moins une majuscule.";
        }
        //Check a minimum of one special char in the password
        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
            $this->errors[] = "Le mot de passe doit contenir au moins un symbole spécial.";
        }
        //Check a minimum of one lowercase in the password
        if (!preg_match('/[a-z]/', $password)) {
            $this->errors[] = "Le mot de passe doit contenir au moins une minuscule.";
        }
        if (empty($this->errors)) {
            $passwordIsValid = true;
        }
        return $passwordIsValid;
    }
}
