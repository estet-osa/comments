<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('owner', TextType::class, array(
                'label'     => 'Имя',
                'required'  => true,
                'attr'      => array(
                    'placeholder' => 'Ваше имя...',
                )
            ))
            ->add('email', EmailType::class, [
                'label'     => 'E-mail',
                'required'  => true,
                'attr'      => array(
                    'placeholder' => 'Ваш email...',
                )
            ])
            ->add('msg', TextareaType::class, [
                'label'     => 'Комментарий',
                'attr'      => array(
                    'placeholder' => 'Текст комментария...',
                )
            ])
            ->add('save', SubmitType::class, [
                'label'     => 'Записать',
                'attr'      => array(
                    'class' => 'save_btn',
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Comment',
        ));
    }
}
