<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public const BASSE_PATH = 'uploads/images/users';
    public const UPLOAD_DIR = 'public/uploads/images/users';
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('tel'),
            TextField::new('email'),
            TextField::new('password')->hideOnIndex(),
           ImageField::new('photo')->setBasePath(self::BASSE_PATH)->setUploadDir(self::UPLOAD_DIR)->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
        ];
    }

}
