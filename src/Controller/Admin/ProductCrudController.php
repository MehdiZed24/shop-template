<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProductCrudController extends AbstractCrudController
{
  public static function getEntityFqcn(): string
  {
    return Product::class;
  }


  public function configureFields(string $pageName): iterable
  {
    return [
      TextField::new('name')->setLabel("Produit"),
      SlugField::new('slug')->setTargetFieldName('name'),
      ImageField::new('illustration')
        ->setLabel("Photo")
        ->setBasePath('uploads/')
        ->setUploadDir('public/uploads')
        ->setUploadedFileNamePattern('[randomhash].[extension]')
        ->setRequired(true), //Le cours met cela à false mais cela propose à l'utilisateur de ne rien mettre et me renvoie une image.

      TextField::new('subtitle'),
      TextareaField::new('description')->setLabel("Description"),
      MoneyField::new('price')->setCurrency('EUR')->setLabel("Prix"),
      AssociationField::new('category')->setLabel("Catégorie")
    ];
  }
}
