<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Warning;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WarningType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('receiver', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'selectize'
                ],
                'placeholder' => 'Select user'
            ])
            ->add('percentage', ChoiceType::class, [
                'choices' => [
                    '10%' => 10,
                    '20%' => 20,
                    '30%' => 30,
                    '40%' => 40,
                    '50%' => 50,
                    '60%' => 60,
                    '70%' => 70,
                    '90%' => 80,
                    '200%' => 90,
                    '100%' => 100,
                ]
            ])
            ->add('reason', TextType::class)
            ->add('expires', DateTimeType::class, [
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d H:i:s'),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Warning::class,
        ]);
    }
}
