<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class PhoneType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phone', TextType::class, array(
                'label'     => 'Teléfono * ',
                'required'  => false,
                'attr'      => array('class' => 'form-control'),
            ))
            /*->add('phoneType', EntityType::class, array(
                'label'         => 'Tipo *',
                'class'         => 'AppBundle:PhoneType',
                'choice_label'  => 'type',
                'attr'          => array('class' => 'form-control'),
            ))*/
            //->add('member')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    //public function configureOptions(OptionsResolver $resolver)
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Phone',
        ));
    }

    /**
     * @return string
     */
    public function getBlockPrefix()
    {
        return 'appbundle_phone';
    }
}