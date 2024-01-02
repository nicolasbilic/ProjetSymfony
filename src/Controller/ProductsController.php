<?php

namespace App\Controller;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductFormType;
use Symfony\Bundle\SecurityBundle\Security;

#[Route('admin/products/')]
class ProductsController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    #[Route('list', name: 'app_list_products')]
    public function displayList(ProductRepository $productRepo): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        $products = $productRepo->findAll();

        return $this->render('products/list.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('new', name: 'app_new_product')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);
        $targetDirectory = 'img/products/';
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            if ($file !== null) {
                $fileName = $file->getClientOriginalName();
                $file->move($targetDirectory, $fileName);
                $product->setPicture($targetDirectory . $fileName);
            }
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_list_products');
        }
        return $this->render('products/new.html.twig', [
            'title' => 'Création d\'un produit',
            'form' => $form,
        ]);
    }

    #[Route('update/{id}', name: 'app_update_product')]
    public function update(
        Request $request,
        EntityManagerInterface $em,
        ?Product $product,
    ) {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        if ($product === null) {
            return $this->redirectToRoute('app_list_products');
        }

        $targetDirectory = 'img/products/';
        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form['file']->getData();
            if ($file !== null) {
                $fileName = $file->getClientOriginalName();
                $file->move($targetDirectory, $fileName);
                $product->setPicture($targetDirectory . $fileName);
            }
            $em->persist($product);
            $em->flush();
        }
        return $this->render('products/new.html.twig', [
            'title' => 'Mise à jour d\'un produit',
            'form' => $form,
        ]);
    }

    #[Route('delete/{id}', name: 'app_delete_product')]
    public function delete(
        EntityManagerInterface $em,
        ?Product $product,
    ) {
        $user = $this->security->getUser();
        if (!$user instanceof Admin) {
            return $this->redirectToRoute('app_admin_login');
        }
        if ($product === null) {
            return $this->redirectToRoute('app_list_products');
        }
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('app_list_products');
    }
}
