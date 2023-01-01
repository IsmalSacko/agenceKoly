<?php

namespace App\Controller\Admin;

use App\Entity\Apros;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AprosCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Apros::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
