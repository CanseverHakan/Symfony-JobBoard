<?php

namespace App\Controller\Admin;

use App\Entity\ContractType;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;

class ContractTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ContractType::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Type de Contrat'),
            SlugField::new('slug')
                ->setTargetFieldName('name'),
            DateTimeField::new('createdAt', 'Créé le')
                ->hideOnForm()->setFormat('dd-MM-YY')
        ];
    }
}
