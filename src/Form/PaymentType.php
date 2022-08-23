<?php

namespace App\Form;

use App\DTO\Payment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PaymentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber',  TextType::class, [
                'required'=>true
                ])
            ->add('cardName',  TextType::class, [
                'required'=>true])

            ->add('dateExpiration', DateType::class,[
                'required'=>true
                ])
            ->add('cvc', NumberType::class, [
                'label'=>'CVC',
                'required'=>true,
            ])
            ->add('send', SubmitType::class, [
                'label'=>'Envoyer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Payment::class,
        ]);
    }
}
