<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;



class SearchType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Search::class,
            'method' => 'GET',
            'crsf_protection' => false,
        ]);
    }

    public function getBlockPrefix(){
        return 'search_type';
    }


    public function buildForm(FormBuilderInterface $builder, array $options){
        
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Votre recherche...',
                    'class' => 'form-control-sm'
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'label' => false,
                'required' => false,
                'multiple' => true,
                'expanded' => true
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'rechercher',
                'attr' => [
                    'class' => 'btn btn-info btn-block btn-sm'
                ]
            ])
            ;


    }


}