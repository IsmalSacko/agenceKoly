<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Headers;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\PostCrudController;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {

    }


    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {

         $url = $this->adminUrlGenerator->setController(PostCrudController::class)->generateUrl();
         return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Koly Agence',);
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Annonces', 'fa fa-home');
        yield MenuItem::linkToCrud('Categories', 'fa fa-list', Category::class);
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::linkToCrud('Headers', 'fas fa-desktop', Headers::class);

    }
}
