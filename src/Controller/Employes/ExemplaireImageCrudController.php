<?php

namespace App\Controller\Employes;

use App\Entity\ExemplaireImage;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExemplaireImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExemplaireImage::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield from parent::configureFields($pageName);
        yield AssociationField::new('exemplaire');
    }
    
}
