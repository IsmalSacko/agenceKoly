<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePwdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname',TextType::class, [
                'label' => 'Votre prénom',
                'attr' => [
                    'placeholder' => 'Votre prénom'
                ]

            ])
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'attr' => [
                    'placeholder' => 'Votre nom',
                ]
            ])
            ->add('email', null, [
                'label' => 'Votre adresse email',
                'attr' => [
                    'placeholder' => 'Votre adresse email',

                ],
            ])
            ->add('tel', TelType::class, [
                'label' => 'Votre numéro de téléphone',
            ])
           ->add('oldPassword', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
               'required'=>true,
               'mapped'=>false,
            ])
            ->add('newPasswd', RepeatedType::class,[
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message'=> "Les mot de passe doivent être identiques 👌",
                'required' => true,
                'first_options' =>['label' => 'Mon nouveau mot de passe','attr'=>['placeholder'=>'Définir un nouveau mot de passe']],
                'second_options' => ['label' => 'Saisir votre nouveau mot de passe',
                    'attr'=>[
                        'placeholder' => 'Confirmez votre nouveau mot de passe'
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
