<?php

namespace App\Form;

use App\Entity\UserList;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('list_name',TextType::class, [
                'attr'=> [
                    'class' => 'form-control'
                ]
            ])
            ->add('description',TextType::class, [
                'attr'=> [
                    'class' => 'form-control'
                ]
            ])
            ->add('users',TextType::class, [
                'attr'=> [
                    'class' => 'form-control'
                ]
            ])
            ->add('user_list_movies',TextType::class, [
                'attr'=> [
                    'class' => 'form-control'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserList::class,
        ]);
    }
}
