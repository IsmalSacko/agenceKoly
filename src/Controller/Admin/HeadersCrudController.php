<?php

namespace App\Controller\Admin;

use App\Entity\Headers;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HeadersCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Headers::class;
    }
    public const BASSE_PATH = 'uploads/images/headers';
    public const UPLOAD_DIR = 'public/uploads/images/headers';

    public function configureFields(string $pageName): iterable
    {

        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('title', 'Titre'),
            TextEditorField::new('content', 'Contenu'),
            TextField::new('btnTitle', 'Titre du bouton'),
            TextField::new('btnUrl', 'Lien du bouton'),
            ImageField::new('image', 'Image')->setBasePath(self::BASSE_PATH)->setUploadDir(self::UPLOAD_DIR)->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
        ];
    }

}
