<?php

namespace App\Form;

use Faker\Core\Number;
use App\DTO\SearchCategoryCriteria;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'required'=>false,
            ])
            ->add('orderBy',  ChoiceType::class,[
                'required'=>true,
                'choices' => [
                    'id'=>'id', 
                    'name'=>'name'
                ],
            ])
            ->add('direction', ChoiceType::class, [
                'required'=>true,
                'choices' => [
                    'DESC' =>'DESC', 
                    'ASC'=>'ASC'
                ],
                ])
            ->add('limit', NumberType::class, [
                'required'=>true,
            ])
            ->add('page', NumberType::class, [
                'required'=>true,
            ])
            ->add('send', SubmitType::class, [
                'label'=>'Envoyer',            
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchCategoryCriteria::class,
            'method'=>'GET',
            'csrf' => 'false',
        ]);
    }
}
