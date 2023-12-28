<?php
// src/Controller/IndexController.php
namespace App\Controller;

use App\Entity\Product;
use App\Repository\OrderRepository;
use App\Services\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Services\UserManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class BasketController extends AbstractController
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function displayBasket(UserManager $userManager, CartService $cartService): Response
    {

        $this->loadUserBasket($cartService);
        $products = $cartService->getCartList();
        $totalPrice = $cartService->calculateBasketTotal($products);
        return $this->render(
            'basketUser/basket.html.twig',
            [
                "totalePrice" => $totalPrice,
                "products" => $products,
                'isLoggedIn' => $userManager->isLoggedIn,
            ]
        );
    }

    public function loadUserBasket(CartService $cartService): void
    {
        $user = $this->getUser(); // Je Récupère l'utilisateur connecté
        if ($user) { // Si l'utilisateur existe
            // J'utilise mon cartService pour vérifier s'il a un panier, si c'est le cas, je le récupère
            if ($user->getRoles()[0] === 'customer') {
                $cart = $cartService->getCartForUser($user);
                if ($cart === null) { // Si l'utilisateur n'a pas de panier, je crée un nouveau panier
                    $cartService->createCartForUser($user);
                    // $this->addFlash('success', 'Votre panier a été créé avec succès.');
                    $this->redirectToRoute('homepage');
                }
            }
        }
    }

    public function handleEventCartForm($idProduct, EntityManagerInterface $em, CartService $cartService)
    {
        $user = $this->getUser();
        if ($user) {
            $product = $em->getRepository(Product::class)->find($idProduct);
            $cartService->addProductToCart($user, $product, 1);
        }
        //Redirect user on the current page
        $referer = $this->requestStack->getCurrentRequest()->headers->get('referer');
        return new RedirectResponse($referer);
    }

    public function handleEventCountForm(Request $request, EntityManagerInterface $em, CartService $cartService)
    {

        $user = $this->getUser();
        if ($user) {
            $actionValue = $request->request->get('actionCount');
            $productId = $request->request->get('id_product');
            $product = $em->getRepository(Product::class)->find($productId);
            $cartService->modifyQuantity($actionValue, $user, $product);
        }
        //Redirect user on the current page
        $referer = $this->requestStack->getCurrentRequest()->headers->get('referer');
        return new RedirectResponse($referer);
    }

    public function handleEventClearForm(Request $request, EntityManagerInterface $em, CartService $cartService)
    {
        $user = $this->getUser();
        if ($user) {
            $cartService->createNewCart($user);
            $this->loadUserBasket($cartService);
        }
        //Redirect user on the current page
        $referer = $this->requestStack->getCurrentRequest()->headers->get('referer');
        return new RedirectResponse($referer);
    }
}
