<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Matter;
use App\Entity\Opinion;
use App\Entity\Products;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[IsGranted('ROLE_ADMIN')]
class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]

    public function index(): Response
    {
                
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MStitchBoutique');
    }

    public function configureMenuItems(): iterable
    {
        return [

            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'), // Ajout de Dashboard            
            MenuItem::linkToCrud('utilisateurs', 'fas fa-list', User::class),  // Ajout de utilisateurs          
            MenuItem::linkToCrud('Products', 'fas fa-list', Products::class), // Ajout de Artisans            
            MenuItem::linkToCrud('Opinion', 'fas fa-list', Opinion::class),  // Ajout de Avis              
            MenuItem::linkToCrud('Category', 'fas fa-list', Category::class),// Ajout de Type 
            MenuItem::linkToCrud('Matter', 'fas fa-list', Matter::class),
            
        ];
    }
}
