<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Matter;
use App\Entity\Products;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\MatterRepository;
use App\Repository\OpinionRepository;
use App\Repository\ProductsRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ProductsRepository $productsRepository, CategoryRepository $categoryRepository, MatterRepository $matterRepository, OpinionRepository $opinionRepository): Response
    {
        $i = [1,2,3,4];

        $lastProducts = $productsRepository->find2LastInserted();


        return $this->render('home/index.html.twig', [
            'i' => $i,
            'lastProducts' => $lastProducts,
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll(),
            'opinion' => $opinionRepository->findAll(),

        ]);
    
    }


    #[Route('/category/{id}', name: 'app_category_products', requirements:["id"=>"\d+"])]

    public function categories(Category $category, ProductsRepository $productsRepository, CategoryRepository $categoryRepository, MatterRepository $matterRepository)
    {
        return $this->render('products/categoryProducts.html.twig', [
            'category'=> $category,
            'allProductsFromCategory'=> $productsRepository->findAll(),
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);
    }

    #[Route('/matter/{id}', name: 'app_matter_products', requirements:["id"=>"\d+"])]

    public function matter(Category $category, Matter $matter, ProductsRepository $productsRepository, CategoryRepository $categoryRepository, MatterRepository $matterRepository)
    {
        return $this->render('products/matterProducts.html.twig', [
            'category'=>$category,
            'matter'=> $matter,
            'allProductsFromCategory'=> $productsRepository->findAll(),
            'allProductsFromMatter'=> $productsRepository->findAll(),
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);
    }

    #[Route('/profil/{id}', name: 'app_profil', requirements:["id"=>"\d+"])]

    public function profil(int $id,User $user, UserRepository $userRepository, ProductsRepository $productsRepository, CategoryRepository $categoryRepository, MatterRepository $matterRepository)
    {
        return $this->render('home/profil.html.twig', [
            
            'userProfils'=>$user,
            'profil' => $userRepository->find($id),
            "items"=> $productsRepository->findAll(),
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);
    }
    
     
}
