<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class, [
                'disabled' => true,
                'label' => 'mon prénom'
            ])
            ->add('lastName', TextType::class, [
                'disabled' => true,
                'label' => 'mon nom'
            ])
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'mon email'
            ])
            ->add('old_password', PasswordType::class, [
                'mapped' => false,
                'label' => 'Mon mot de passe actuel',
                'attr' => [
                    'placeholder' => 'Saisir votre mot de passe actuel'
                ]    
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'veuillez entrer deux mots de passe identique',
                'label' => 'Saisir votre nouveau mot de passe',
                'required' => true,
                'constraints' => new Length([
                    'min' => 3,
                    'max' => 15
                ]),
                'first_options' => [
                    'label' => 'Mon nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'saisir votre nouveau mot de passe'
                    ]
                ],
                 'second_options' => [
                     'label' => 'Répetez votre nouveau mot de passe',
                     'attr' => [
                         'placeholder' => 'confirmez votre nouveau mot de passe'
                     ]
                ]   
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'btn btn-primary btn-block'
                ]
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
