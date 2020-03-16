<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Forum;
use App\Entity\UserRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ForumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class, [
                'required' => false
            ])
            ->add('minRole', EntityType::class, [
                'class' => UserRole::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Select a role',
                'label' => 'Minimum access role',
                'attr' => [
                    'class' => 'selectize'
                ]
            ])
            ->add('subforum', EntityType::class, [
                'class' => Forum::class,
                'choice_label' => 'name',
                'required' => false,
                'placeholder' => 'Select a parent forum',
                'group_by' => function ($choice, $key, $value) {
                    if($choice->getId() == $value) {
                        return $choice->getCategory()->getName();
                    }
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Forum::class,
        ]);
    }
}
