<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ProductFormType;

#[Route('admin/products/')]
class ProductsController extends AbstractController
{
    #[Route('list', name: 'app_list_products')]
    public function list(ProductRepository $productRepo, Request $request): Response
    {
        $products = $productRepo->findAll();

        return $this->render('products/list.html.twig', [
            'title' => 'Liste des produits',
            'products' => $products,
        ]);
    }

    #[Route('new', name: 'app_new_product')]
    public function new(EntityManagerInterface $em, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($product);
            $em->flush();
            // $file = $form['file']->getData();
            // $fileName = 'idduproduit+datetimenow';
            // $file->move('images', $fileName);
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
        if ($product === null) {
            return $this->redirectToRoute('app_list_products');
        }

        $form = $this->createForm(ProductFormType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em->persist($product);
            $em->flush();
            return $this->redirectToRoute('app_list_products');
        }
        return $this->render('products/new.html.twig', [
            'title' => 'Mise à jour d\'un produit',
            'form' => $form,
        ]);
    }
}
