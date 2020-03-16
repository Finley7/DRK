<?php

namespace App\Form;

use App\Entity\Ban;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BanType extends AbstractType
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
            ->add('notes', TextType::class, [
                'label' => 'Management notes (not visible for user)',
                'required' => false
            ])
            ->add('reason', TextType::class)
            ->add('expires', DateTimeType::class, [
                'attr' => [
                    'min' => (new \DateTime())->format('Y-m-d H:i:s'),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ban::class,
        ]);
    }
}
