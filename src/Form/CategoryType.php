<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Permission;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('description', TextType::class)
            ->add('permission', EntityType::class, [
                'class' => Permission::class,
                'placeholder' => 'Select permission',
                'required' => false,
                'attr'=> [
                    'class' => 'selectize'
                ],
                'choice_label' => function (Permission $permission) {
                    return $permission->getDescription() . ' ('.$permission->getName().')'; ;
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
