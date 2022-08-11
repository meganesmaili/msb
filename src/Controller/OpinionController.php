<?php

namespace App\Controller;

use App\Entity\Opinion;
use App\Entity\Products;
use App\Form\OpinionType;
use App\Repository\CategoryRepository;
use App\Repository\MatterRepository;
use App\Repository\OpinionRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpinionController extends AbstractController
{
    #[Route('/opinion/{id}', name: 'app_opinion', requirements:['id' => '\d+'])]
    #[IsGranted("ROLE_USER")]
    public function index(Products $products, Request $request, OpinionRepository $opinionRepository,CategoryRepository $categoryRepository, MatterRepository $matterRepository): Response
    {


        $opinion = New Opinion();
        $form = $this->createForm(OpinionType::class, $opinion);
        $form->handleRequest($request);
        

        if($form->isSubmitted() && $form->isValid()) {
            $opinion->setProducts($products);
            $opinionRepository->add($opinion, true);
            $this->addFlash('sucess', 'Merci pour votre avis');

            return $this->redirectToRoute('app_home');

        }

        return $this->render('opinion/index.html.twig', [
            'form'=> $form->createView(),
            'productsCategory' => $categoryRepository->findAll(),
            'productsMatter' => $matterRepository->findAll()
        ]);
    }
}
