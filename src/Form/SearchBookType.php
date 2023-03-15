<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Category;
use App\DTO\SearchBookCriteria;
use App\Entity\PublishingHouse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class,[
                'required'=> false
            ])
            ->add('authors', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required'=> false
            ])
            ->add('categories', EntityType::class, [
                'class' =>Category::class,
                'choice_label' => 'name',
                'required' => false,
                'multiple' => true,
            ])
            ->add('minPrice', MoneyType::class, [
                'required' => false
            ])
            ->add('maxPrice', MoneyType::class, [
                'required'=> false
            ])
            ->add('publishingHouses', EntityType::class, [
                'label' => 'Publishing house',
                'class'=>PublishingHouse::class,
                'choice_label' => 'name',
                'required' => false,
                'expanded' => true,
                'multiple' => true           
            ])
            ->add('orderBy',  ChoiceType::class,[
                'required'=> true,
                'choices' => [
                    'id'=>'id', 
                    'title'=>'title',
                    'price'=>'price',
                ],
            ])
            ->add('direction', ChoiceType::class, [
                'required'=> true,
                'choices' => [
                    'DESC' =>'DESC', 
                    'ASC'=>'ASC'
                ],
                ])
            ->add('limit', NumberType::class, [
                'required'=> true,
            ])
            ->add('page', NumberType::class, [
                'required'=> true,
            ])
            ->add('send', SubmitType::class, [
                'label'=> 'envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchBookCriteria::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }
}
