<?php

namespace App\Services;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Basket;
use App\Entity\BasketLine;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private  $requestStack;
    private  $em;
    private  $security;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em,  Security $security)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
        $this->security = $security;
    }

    public function getCartForUser(Customer $user): ?Basket
    {
        // Je récupère le panier de l'utilisateur
        $baskets = $user->getBasket();
        // Je retourne le premier panier trouvé
        return $baskets->isEmpty() ? null : $baskets->first();
    }

    // public function getCartList(): array
    // {
    //     $user = $this->security->getUser();
    //     $basketLines = [];

    //     if ($user) {
    //         if ($user->getRoles()[0] === 'customer') {
    //             $cart = $this->getCartForUser($user);

    //             if ($cart) {
    //                 foreach ($cart->getBasketLine() as $basketLine) {
    //                     $products[] = $basketLine->getProduct();
    //                 }
    //             }
    //         }
    //     }

    //     return $basketLines;
    // }
    public function getCartList(): array
    {
        $user = $this->security->getUser();
        $basketLines = [];

        if ($user) {
            if ($user->getRoles()[0] === 'customer') {
                $cart = $this->getCartForUser($user);
                if ($cart) {
                    $basketLines = $cart->getBasketLine()->toArray();
                }
            }
        }

        return $basketLines;
    }

    public function addProductToCart(Customer $user,  Product $product, int $quantity)
    {

        // Vérifier si le produit existe déjà dans le panier
        $cart = $this->getCartForUser($user);

        foreach ($cart->getBasketLine() as $basketLine) {
            if ($basketLine->getProduct()->getId() === $product->getId()) {
                // Le produit existe déjà dans le panier
                // Incrémenter la quantité de la BasketLine existante dans la base de données
                $basketLine->setQuantity($basketLine->getQuantity() + $quantity);
                $this->em->persist($basketLine);
                $this->em->flush();
                return; // Arrêter la fonction ici puisque le produit existe déjà
            }
        }

        // Si le produit n'existe pas dans le panier, ajoutez-le comme d'habitude
        $basketLine = new BasketLine();
        $basketLine->setProduct($product);
        $basketLine->setQuantity($quantity);

        // Ajouter la ligne de panier au panier
        $cart->addBasketLine($basketLine);

        // Persistez les entités
        $this->em->persist($cart);
        $this->em->persist($basketLine);
        $this->em->flush();
    }


    public function createCartForUser(Customer $user): void
    {
        // Je vérifie si l'utilisateur a déjà un panier
        $existingBasket = $this->getCartForUser($user);

        /****************** test à garder ******************
        $user = $this->em->getRepository(Customer::class)->findOneBy(['email' => 'nicole@gmail.com']); */

        if ($existingBasket === null) {
            // Si l'utilisateur n'a pas de panier, je crée le panier et l'attribue à l'utilisateur
            $basket = new Basket();
            $basket->setCustomer($user);

            //Ajoute le panier à l'utilisateur et le rentre dans la base de données
            $user->addBasket($basket);
            $this->em->persist($basket);
            $this->em->flush();
        }
    }


    private function getSession(): SessionInterface
    {
        return $this->requestStack->getSession();
    }


    public function addToCart(int $id)
    {
        $cart = $this->getSession()->get('cart', []);
        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
        $this->getSession()->set('cart', $cart);
    }


    public function removeToCart(int $id)
    {
        $cart = $this->requestStack->getSession()->get('cart', []);
        unset($cart[$id]);
        return $this->getSession()->set('cart', $cart);
    }


    public function decrease(int $id)
    {
        $cart = $this->getSession()->get('cart', []);
        if ($cart[$id] > 1) {
            $cart[$id]--;
        } else {
            unset($cart[$id]);
        }
        $this->getSession()->set('cart', $cart);
    }


    public function removeCartAll()
    {
        return $this->getSession()->remove('cart');
    }


    public function getTotal(): array
    {
        $cart = $this->getSession()->get('cart');
        $cartData = [];
        if ($cart) {
            foreach ($cart as $id => $quantity) {
                $product = $this->em->getRepository(Product::class)->findOneBy(['id' => $id]);
                if (!$product) {
                    // Supprimer le produit puis continuer en sortant de la boucle
                }
                $cartData[] = [
                    'product' => $product,
                    'quantity' => $quantity
                ];
            }
        }
        return $cartData;
    }
}
