<?php

namespace App\Controller\Employes;

use App\Entity\Exemplaire;
use App\Form\Type\ExemplaireImageType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class ExemplaireCrudController extends AbstractCrudController
{   
    public static function getEntityFqcn(): string
    {
        return Exemplaire::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('vehicule');
        yield AssociationField::new('categorie');
        yield AssociationField::new('type');
        yield IntegerField::new('prix');
        yield IntegerField::new('annee');
        yield IntegerField::new('kilometrage');
        //yield TextareaField::new('imageFile')->setFormType(VichImageType::class)->hideOnIndex();
        //yield ImageField::new('imageName')->setBasePath('/images/vehicules')->hideOnForm();
        yield CollectionField::new('image')
            ->setEntryType(ExemplaireImageType::class)
            //->onlyOnForms()
            ->setFormTypeOption('allow_add', true)
            ->setFormTypeOption('allow_delete', true);
        yield TextareaField::new('description');
        yield TextareaField::new('options');
    }
}