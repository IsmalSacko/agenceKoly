<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdatePwdType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('new_password',RepeatedType::class,[
                'type' => PasswordType::class,
                'invalid_message'=> 'Le mot de passe et la confirmation doivent être identiques !',
                'label' => 'Mot de passe actuel',
                //'mapped' => false,
                'required' => true,
                'first_options' => ['label' => 'Mon nouveau mot de passe','attr'=>['placeholder'=>'Définir un nouveau mot de passe']],
                'second_options' => ['label' => 'Confirmez le nouveau mot de passe',
                    'attr'=>[
                        'placeholder' => 'Confirmez le mot de passe'
                    ]
                ],

            ])
            ->add('submit', SubmitType::class,[
                'label' => 'Mettre à jour mon mot de passe',
                'attr'=>[
                    'class'=>'btn btn-info btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
