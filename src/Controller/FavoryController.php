<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FavoryController extends AbstractController
{
    #[Route('/favory', name: 'app_favory')]
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/annonces_favories.html.twig', [
            'post' => $postRepository->findBy(['isFovory' => true]),
        ]);
    }
}
