<?php

namespace App\Controller;

use App\Form\ChangePwdType;
use App\Form\UpdatePwdType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/compte')]
class AcountController extends AbstractController
{
    private EntityManagerInterface $manager;
    private EntityManagerInterface $encoder;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;

    }


    #[Route('/', name: 'compte_index')]
    public function index(): Response
    {
        return $this->render('acount/index.html.twig', [
           'user' => $this->getUser(),
        ]);
    }
    #[Route('/modification', name: 'password_update')]
    public function update(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $suer = $this->getUser();
        $from = $this->createForm(ChangePwdType::class , $suer);
        $from->handleRequest($request);
        if ($from->isSubmitted() && $from->isValid()){
            $old_pwd = $from->get('oldPassword')->getData();
            $new_pwd = $from->get('newPasswd')->getData();

            if ($hasher->isPasswordValid($suer, $old_pwd)){
               $suer->setPassword($hasher->hashPassword($suer, $new_pwd));
                $this->manager->flush();
                $this->addFlash('success', 'Votre mot de passe a été modifié avec succès');
                return $this->redirectToRoute('compte_index');
           }else {
                $this->addFlash('danger', 'Le mot de passe saisi n\'est pas identique à votre mot de passe actuel');
        }
        }
        return $this->render('acount/password.html.twig', [
            'form' => $from->createView(),
        ]);

    }
}