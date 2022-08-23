<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('street', TextType::class, [
            'label' => 'N° de la rue :',
            'required' => true,
        ])
        ->add('city', TextType::class, [
            'label' => 'Ville :',
            'required' => true,
        ])
        ->add('zipCode', TextType::class, [
            'label' => 'Code Postale :',
            'required' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
