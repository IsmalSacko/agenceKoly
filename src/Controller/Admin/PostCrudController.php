<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class PostCrudController extends AbstractCrudController
{
    public const BASSE_PATH = 'uploads/images/posts';
    public const UPLOAD_DIR = 'public/uploads/images/posts';
    public const PRODUCT_DUPLUCATE = 'duplicate';
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }
    public function configureActions(Actions $actions): Actions
    {
       $duplicate = Action::new(self::PRODUCT_DUPLUCATE)->linkToCrudAction('productduplicate')->setCssClass('btn btn-primary')->setIcon('fa fa-copy');
       return $actions->add(Crud::PAGE_EDIT, $duplicate);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm()->hideOnIndex(),
            TextField::new('title', 'Titre'),
            SlugField::new('slug')->setTargetFieldName('title')->hideOnIndex(),
            TextEditorField::new('description'),
            MoneyField::new('prix')->setCurrency('XAF')->setNumDecimals(0),
            TextField::new('localite','Localité'),
            NumberField::new('nb', 'Nombre'),
            ImageField::new('image')->setBasePath(self::BASSE_PATH)->setUploadDir(self::UPLOAD_DIR)->setUploadedFileNamePattern('[randomhash].[extension]')->setRequired(false),
            DateTimeField::new('createad_at','Date')->hideOnForm()->setFormat('dd/MM/yyyy'),
            AssociationField::new('category', 'Catégories')->setQueryBuilder(function ($queryBuilder) {
                return $queryBuilder->where('entity.active = true');
            }),
            BooleanField::new('isFovory', 'Favoris'),

        ];
    }
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if (!$entityInstance instanceof Post) return;
            $entityInstance->setCreateadAt(new \DateTimeImmutable());
            //$entityInstance->setSlug($this->slugify($entityInstance->getTitle()));
            parent::persistEntity($entityManager, $entityInstance);
    }
    public function productduplicate(AdminContext $adminContext, EntityManagerInterface $entityManager, AdminUrlGenerator $adminUrlGenerator):Response{
    /**@var Post::$post*/
    $post = $adminContext->getEntity()->getInstance();
    $newPost = clone $post;
    parent::persistEntity($entityManager, $newPost);
    $url = $adminUrlGenerator->setController(self::class)->setAction(Action::DETAIL)->setEntityId($newPost->getId())->generateUrl();
    return $this->redirect($url);
    }

}
