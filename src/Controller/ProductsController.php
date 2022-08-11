<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\MatterRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'app_products')]
    public function index(ProductsRepository $productsRepository, CategoryRepository $categoryRepository, MatterRepository $matterRepository): Response
    {

        return $this->render('products/index.html.twig', [
            'products' => $productsRepository->findAll(),
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);
    }

    //Obtenir le détail d'un artisan via le tableau
    #[Route('/products/{id}', name: 'app_details_products', requirements:["id"=>"\d+"])]
    public function details( int $id, ProductsRepository $productsRepository, CategoryRepository $categoryRepository, MatterRepository $matterRepository)
    {
      
        return $this->render('products/product.html.twig', [

            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll(),
            'oneProducts' => $productsRepository->find($id)
          
           
        ]);
    }
}
