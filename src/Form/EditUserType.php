<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, [
                'attr' => [
                    'class'=> 'form-control'
                ],
            ])
            ->add('email', EmailType::class, [
              'constraints' => [
                new NotBlank([
                  'message' => 'Please enter an email address'
                ])
              ],
              'required' => true,
              'attr' => [
                'class' => 'form-control'
              ]
            ])
            ->add('roles', ChoiceType::class, [
              'choices' => [
                'User' => 'ROLE_USER',
                'Admin' => 'ROLE_ADMIN'
              ],
              'expanded' => true,
              'multiple' => true
              
            ])
            ->add('Valider', SubmitType::class, [
                'attr'=> [
                    'class'=>'form-control'
                ],
                'label'=> 'Validate'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
