<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                'label' => 'Prénom',
                'constraints' => new Length([
                    'min' => 4,
                    'max' => 50,
                    'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères',
                    'maxMessage' => 'Votre prénom doit faire au plus {{ limit }} caractères',
                ]),
                'required' =>true,
                'attr'=>[
                    'placeholder' => 'Entre le prénom'
                ]
            ])
            ->add('lastname',TextType::class,[
                'label' => 'Nom',
                'constraints' => new Length([
                    'min' => 4,
                    'max' => 50,
                    'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                    'maxMessage' => 'Votre nom doit faire au plus {{ limit }} caractères',
                ]),
                'required' => true,
                'attr'=>[
                    'placeholder' => 'Entrer le nom'
                ]
            ])
            ->add('email',EmailType::class,[
                'label' =>'Email',
                'constraints' => new Email([
                    'message' => 'L\'email "{{ value }}" n\'est pas valide',
                ]),
                'required' =>true,
                'attr'=>[
                    'placeholder' => "L'email"
                ]
            ])
            ->add('password', RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message'=> "Les mot de passe doivent être identiques 👌",
                'required' => true,
                'first_options' =>['label' => 'Mot de passe','attr'=>['placeholder'=>'Définir un mot de passe']],
                'second_options' => ['label' => 'Confirmez le mot de passe',
                    'attr'=>[
                        'placeholder' => 'Confirmez le mot de passe'
                    ]
                    ],
            ])
           ->add('submit', SubmitType::class,[
                'label' => "S'inscrire",
                'attr' =>['class' =>'bnt btn-primary btn-block']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
