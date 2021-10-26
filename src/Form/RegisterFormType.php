<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Entrez votre nom'
                ]
            ])
             ->add('lastname', TextType::class, [
                 'label' => 'Prénom',
                 'attr' => [
                     'placeholder' => 'Entrez votre prénom'
                 ]
             ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Entrez votre email'
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'veuillez entrer deux mots de passe identique',
                'label' => 'saisir votre mot de passe',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 15
                ]),
                'first_options' => [
                    'label' => 'Mot de passe',
                    'attr' => [
                        'placeholder' => 'saisir votre mot de passe'
                    ]
                ],
                 'second_options' => [
                     'label' => 'Répetez votre mot de passe',
                     'attr' => [
                         'placeholder' => 'confirmez votre mot de passe'
                     ]
                ]   
            ])
            ->add('submit', SubmitType::class, [
                'label' => "S'inscrire"
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
