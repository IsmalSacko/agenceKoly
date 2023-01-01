<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AprosController extends AbstractController
{
    #[Route('/apros', name: 'app_apros')]
    public function index(): Response
    {
        return $this->render('apros/aprops.html.twig', [
            'controller_name' => 'AprosController',
        ]);
    }
}
