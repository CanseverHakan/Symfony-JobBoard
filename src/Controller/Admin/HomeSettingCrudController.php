<?php

namespace App\Controller\Admin;

use App\Entity\HomeSetting;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class HomeSettingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HomeSetting::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextEditorField::new('message'),
            TextField::new('callToAction'),
            ImageField::new('image')
                ->setBasePath('images/')
                ->setUploadDir('public/images')
                ->setUploadedFileNamePattern('[randomhash]', '[extension]')
                ->setRequired(False),
            DateTimeField::new('createdAt', 'Ajouter le')
                ->hideOnForm()->setFormat('dd-MM-YY')
        ];
    }
}
