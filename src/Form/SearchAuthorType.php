<?php

namespace App\Form;

use App\DTO\SearchAuthorCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchAuthorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class,[
            'required'=>false,
        ])
        ->add('orderBy',  ChoiceType::class,[
            'required' => false,
                'empty_data' => 'id',
            'choices' => ['id'=>'id', 'name'=>'name'],
        ])
        ->add('direction', ChoiceType::class, [
            'required' => false,
                'empty_data' => "ASC",
            'choices' => ['DESC' =>'DESC', 'ASC'=>'ASC'],
            ])
        ->add('limit', NumberType::class, [
            'required' => false,
                'empty_data' => 1,
        ])
        ->add('page', NumberType::class, [
            'required' => false,
                'empty_data' => 1,
        ])
        ->add('send', SubmitType::class, [
            'label'=>'Envoyer',            
        ])
    ;
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchAuthorCriteria::class,
            'method'=>'GET',
            'csrf_protection' => false,
            
        ]);
    }
}
