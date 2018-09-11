<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'label'     => 'Usuario *',
                'required'  => true,
                'attr'      => array('class' => 'form-control'),
            ))
            ->add('password', RepeatedType::class, array(
                'required'          => true,
                'type'              => PasswordType::class,
                'invalid_message'   => 'Las contraseñas no coinciden',
                'options'           => array('attr' => array('class' => 'form-control')),
                'first_options'     => array('label' => 'Contraseña *'),
                'second_options'    => array('label' => 'Repetir la contraseña*'),
                //'attr'              => array('class' => 'form-control')
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    //public function configureOptions(OptionsResolver $resolver)
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Login',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'login';
    }
}