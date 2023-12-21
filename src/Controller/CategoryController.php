<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('admin/categories/')]
class CategoryController extends AbstractController
{
    #[Route('list', name: 'app_list_categories')]
    public function list(CategoryRepository $categoryRepo, Request $request): Response
    {
        $categories = $categoryRepo->findAll();

        return $this->render('categories/list.html.twig', [
            'title' => 'Liste des categories',
            'categories' => $categories,
        ]);
    }

    #[Route('new', name: 'app_new_category')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryFormType::class, $category);
        $targetDirectory = 'img/categories/';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Banner picture
            $bannerFile = $form['bannerPicture']->getData();
            $bannerName = $bannerFile->getClientOriginalName();
            $bannerFile->move($targetDirectory, $bannerName);
            $category->setBannerPicture($targetDirectory . $bannerName);
            // Main picture
            $picture = $form['mainPicture']->getData();
            $pictureName = $picture->getClientOriginalName();
            $picture->move($targetDirectory, $pictureName);
            $category->setPicture($targetDirectory . $pictureName);
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
        if ($category === null) {
            return $this->redirectToRoute('app_list_categories');
        }

        $form = $this->createForm(CategoryFormType::class, $category);
        $targetDirectory = 'img/categories/';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // Banner picture
            $bannerFile = $form['bannerPicture']->getData();
            $bannerName = $bannerFile->getClientOriginalName();
            $bannerFile->move($targetDirectory, $bannerName);
            $category->setBannerPicture($targetDirectory . $bannerName);
            // Main picture
            $picture = $form['mainPicture']->getData();
            $pictureName = $picture->getClientOriginalName();
            $picture->move($targetDirectory, $pictureName);
            $category->setPicture($targetDirectory . $pictureName);
            $em->persist($category);
            $em->flush();
            return $this->redirectToRoute('app_list_categories');
        }
        return $this->render('categories/new.html.twig', [
            'title' => 'Mise à jour d\'une catégorie',
            'form' => $form,
        ]);
    }
}
