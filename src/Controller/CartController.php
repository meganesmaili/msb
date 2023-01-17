<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MatterRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'app_cart')]
    public function index(SessionInterface $session, RequestStack $rs, ProductsRepository $productsRepository, MatterRepository $matterRepository, CategoryRepository $categoryRepository): Response
    {
        $cart = $session->get("cart", []);

        //On fabrique les données

        $dataPanier =[];
        $total = 0;
        
        foreach($cart as $id => $quantity){
            $products = $productsRepository->find($id);
            $dataPanier[] = [
                "product" =>$products,
                'matter'=>$matterRepository->find($id),
                'category'=>$categoryRepository->find($id),
                'quantity'=>$quantity
            ];

             $total+= $products->getPrice() * $quantity;
        }
        
        $session->set('qt',$quantity);

        return $this->render('cart/index.html.twig', [
            'items'=>$dataPanier,
            'total' => $total,
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);

        
        ///*  dd($cartWithData);
       /*  $session->set('qt',$qt);

        $total = 0;
        foreach ($cartWithData as $item) {
            $totalItem = $item['product']->getPrice() * $item['quantity'];
            $total += $totalItem;
        }

        return $this->render('cart/index.html.twig',[
            'items' => $cartWithData,
            'total' => $total,
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);  */

    }

    #[Route('/add/{id}', name:'app_cart_add')]
    public function add($id, SessionInterface $session)
    {
       //On récupère le panier actuel
       $cart = $session->get("cart", []);


        if(!empty($cart[$id]))
            $cart[$id]++;
        else
            $cart[$id]=1;

        $session->set('cart', $cart);
        
        /* dd($session->get('cart')); */
    return $this->redirectToRoute('app_cart');

    }

    #[Route('/remove/{id}', name:'app_cart_remove')]
    public function remove($id, SessionInterface $session)
    {
        $cart = $session->get("cart", []);


        if(!empty($cart[$id])){
            if ($cart[$id] > 1) {
                $cart[$id]--;
            }
            else {
                unset($cart[$id]);
            }
        }
            
        $session->set('cart', $cart);
        
        /* dd($session->get('cart')); */
    return $this->redirectToRoute('app_cart');
        
    }
}
