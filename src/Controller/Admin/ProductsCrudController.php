<?php

namespace App\Controller\Admin;

use App\Entity\Products;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[IsGranted('ROLE_ADMIN')]
class ProductsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Products::class;
    }

    public function configureFields(string $pageName): iterable
    
    {
    
    return [
        TextField::new('name', 'nom'),
        NumberField::new('matter_id'),
        NumberField::new('category_id'),
        TextEditorField::new('description'),
        TextField::new('profileFile', 'image') //Pour charger l'image dans l'edit
        ->setFormType(VichImageType::class) // redimenssionnement avec VichImage
        ImageField::new('picture', 'image') // faire apparaître l'image dans le formulaire
        ->setBasePath('images/products') // chemin d'accés de l'image dans le formulaire
        ->setUploadDir('public/images/products') 
        ->hideOnForm() //pour n'apparaite que dans le form
        
    ];
    }

}
