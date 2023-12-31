<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('admin/categories/')]
class CategoryController extends AbstractController
{
    private $categoryRepo;
    private $security;

    public function __construct(CategoryRepository $categoryRepo, Security $security)
    {
        $this->categoryRepo = $categoryRepo;
        $this->security = $security;
    }

    #[Route('list', name: 'app_list_categories')]
    public function list(): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        $categories = $this->categoryRepo->findAll();

        return $this->render('categories/list.html.twig', [
            'title' => 'Liste des categories',
            'categories' => $categories,
        ]);
    }

    #[Route('new', name: 'app_new_category')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $targetDirectory = 'img/categories/';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Banner picture
            $bannerFile = $form['bannerPicture']->getData();
            if ($bannerFile !== null) {
                $bannerName = $bannerFile->getClientOriginalName();
                $bannerFile->move($targetDirectory, $bannerName);
                $category->setBannerPicture($targetDirectory . $bannerName);
            }
            // Main picture
            $picture = $form['mainPicture']->getData();
            if ($picture !== null) {
                $pictureName = $picture->getClientOriginalName();
                $picture->move($targetDirectory, $pictureName);
                $category->setPicture($targetDirectory . $pictureName);
            }
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_list_categories');
        }
        return $this->render('categories/new.html.twig', [
            'title' => 'Création d\'une catégorie',
            'form' => $form,
        ]);
    }

    #[Route('update/{id}', name: 'app_update_category')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Category $category,
    ) {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        if ($category === null) {
            return $this->redirectToRoute('app_list_categories');
        }

        $form = $this->createForm(CategoryFormType::class, $category);
        $targetDirectory = 'img/categories/';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Banner picture
            $bannerFile = $form['bannerPicture']->getData();
            if ($bannerFile !== null) {
                $bannerName = $bannerFile->getClientOriginalName();
                $bannerFile->move($targetDirectory, $bannerName);
                $category->setBannerPicture($targetDirectory . $bannerName);
            }
            // Main picture
            $picture = $form['mainPicture']->getData();
            if ($picture !== null) {
                $pictureName = $picture->getClientOriginalName();
                $picture->move($targetDirectory, $pictureName);
                $category->setPicture($targetDirectory . $pictureName);
            }
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_list_categories');
        }
        return $this->render('categories/new.html.twig', [
            'title' => 'Mise à jour d\'une catégorie',
            'form' => $form,
        ]);
    }

    #[Route('delete/{id}', name: 'app_delete_category')]
    public function delete(
        EntityManagerInterface $em,
        ?Category $category,
    ) {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        if ($category === null) {
            return $this->redirectToRoute('app_list_categories');
        }
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('app_list_categories');
    }
}
