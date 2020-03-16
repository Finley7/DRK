<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\UserRole;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('email', EmailType::class)
            ->add('password', PasswordType::class, [
                'required' => false,
                'mapped' => false,
            ])
            ->add('userRoles', EntityType::class, [
                'class' => UserRole::class,
                'choice_label' => function (UserRole $role) {
                    return $role->getName() . ' - ' . $role->getDescription();
                },
                'multiple' => true,
                'attr' => [
                    'class' => 'selectize'
                ]
            ])
            ->add('primaryRole', EntityType::class, [
                'class' => UserRole::class,
                'choice_label' => function (UserRole $role) {
                    return $role->getName() . ' - ' . $role->getDescription();
                },
                'attr' => [
                    'class' => 'selectize'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
