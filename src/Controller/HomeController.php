<?php

namespace App\Controller;

use App\Repository\HeadersRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(PostRepository $postRepository, HeadersRepository $headersRepository): Response
    {
        return $this->render('home/home.html.twig', [
            'post' => $postRepository->findBy(['isFovory' => true]),
            'headers' => $headersRepository->findAll(),
        ]);
    }


}
