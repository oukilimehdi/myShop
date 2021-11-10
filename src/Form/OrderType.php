<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Carrier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        //dd($options);
        //je récupere user qui a été passé en parametre d'options
        $user = $options['user'];
        $builder
            ->add('addresses', EntityType::class, [
                'class' => Address::class,
                'choices' => $user->getAddresses(),
                'label' => 'Choisissez votre adresse de livraison',
                'required' => true,
                'multiple' => false,
                'expanded' => true,
            ])
            ->add('carrier', EntityType::class, [
                'class' => Carrier::class,
                'expanded' => true,
                'multiple' => false,
                'required' => true,
                'label' => 'Choisissez votre transporteur'
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider ma commande',
                'attr' => [
                    'class' => 'btn btn-success btn-block'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'user' => []
        ]);
    }
}
