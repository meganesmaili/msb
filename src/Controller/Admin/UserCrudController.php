<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

#[IsGranted('ROLE_ADMIN')]
class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('email');
        yield ArrayField::new('roles');
        yield TextField::new('firstname');
        yield TextField::new('lastname');
        yield TextField::new('pseudo');
        yield TextField::new('password')->setFormType(PasswordType::class)->onlyOnForms()->onlyWhenCreating();
        
        
        
    }
    
}