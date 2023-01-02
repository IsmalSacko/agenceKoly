<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegisterController extends AbstractController
{

    private UserPasswordHasherInterface $encoder;
    private EntityManagerInterface $manager;

    /**
     * RegisterController constructor.
     * @param UserPasswordHasherInterface $encoder
     * @param EntityManagerInterface $manager
     */
    public function __construct(UserPasswordHasherInterface $encoder, EntityManagerInterface $manager)
    {
        $this->encoder = $encoder;
        $this->manager = $manager;
    }

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request): Response
    {
        $user = new User();
        $notification = null;
        $form = $this->createForm(RegisterType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $uniqemail = $this->manager->getRepository(User::class)->findOneByEmail($user->getEmail());
            if (!$uniqemail){
                $user->setPassword($this->encoder->hashPassword($user,$user->getPassword()));
                $this->manager->persist($user);
                $this->manager->flush();
                return$this->redirectToRoute('app_login');
//                $mail = new Mailjet();
//                $content_email = "Bonjour ".$user->getFirstname().","."<br/>Bienvenue sur notre boutique en ligne";
//
//                $mail->send($user->getEmail(), $user->getFirstname(),"Confirmation d'inscription sur la boutique Malienne",
//                    $content_email);
//                $notification = "Votre inscription s'est bien passée, vous pouvez vous connecter dès à présent avec votre compte !";

            }else{
                $notification ="L'email que vous avez renseigné existe déjà !";
            }
        }

        return $this->render('register/register.html.twig',
            [
           'form' => $form->createView(),
            'user' => $user,
            'notify' => $notification,
        ]);
    }
}
