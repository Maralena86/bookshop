<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Author;
use App\Entity\Category;
use App\Entity\PublishingHouse;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdminBookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' =>'Titre du livre',
                'required' => true
            ])
            ->add('price', MoneyType::class, [
                'label' =>'Prix du livre',
                'required' => true
            ])
            ->add('description', TextareaType::class, [
                'label' =>'Description du livre',
                'required' => false
            ])
            ->add('imageUrl', UrlType::class, [
                'label' =>"Url de l'image du livre",
                'required' => false

            ])
            ->add('author', EntityType::class, [
                'class' => Author::class,
                'choice_label' => 'name',
                'label' =>"Choix de l'auteur",
                'multiple'=> false,
                'expanded'=> true,
                'required' => false

            ])
            ->add('categories', EntityType::class, [
                'class' =>Category::class,
                'choice_label' => 'name',
                'label' =>"Choix de l'auteur",
                'multiple'=> true,
                'expanded'=> true,
                'label' =>'Choix de catégories',
                'required' => false

            ])
            ->add('publishHouse', EntityType::class, [
                'class' =>PublishingHouse::class,
                'choice_label' => 'name',
                'label' =>"Choix de la maison du livre",
                'multiple'=> false,
                'expanded'=> true,
                'label' =>'Choix de maison',
                'required' => false

            ])

            ->add('submit', SubmitType::class, [
                'label'=>'Envoyer',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
