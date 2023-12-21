<?php

namespace App\Services;

use App\Entity\Customer;
use App\Entity\Product;
use App\Entity\Basket;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private RequestStack $requestStack;
    private EntityManagerInterface $em;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $em)
    {
        $this->requestStack = $requestStack;
        $this->em = $em;
    }


    public function getCartForUser(Customer $user): ?Basket
    {
        // Je récupère le panier de l'utilisateur
        $baskets = $user->getBasket();

        // Je retourne le premier panier trouvé
        return $baskets->isEmpty() ? null : $baskets->first();
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
