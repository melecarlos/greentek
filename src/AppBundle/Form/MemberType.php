<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class MemberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quotations', CollectionType::class, array(
                    'label'         => false,
                    'entry_type'    => QuotationType::class,
                    'by_reference'  => false,
                    'allow_delete'  => true,
                    'allow_add'     => true,
                ))
                ->add('forename', TextType::class, array(
                    'label'     =>  'Nombres *',
                    'required'  =>  false,
                    'attr'      =>  array('class' => 'form-control')
                ))
                ->add('lastname', TextType::class, array(
                    'label'     =>  'Apellidos *',
                    'required'  =>  false,
                    'attr'      =>  array('class' => 'form-control')
                ))
                ->add('emails', CollectionType::class, array(
                    'label'         => false,
                    'entry_type'    => EmailType::class,
                    'by_reference'  => false,
                    'allow_delete'  => true,
                    'allow_add'     => true,
                ))
                ->add('phones', CollectionType::class, array(
                    'label'         => false,
                    'entry_type'    => PhoneType::class,
                    'by_reference'  => false,
                    'allow_delete'  => true,
                    'allow_add'     => true,
                ))
                ->add('companies', CollectionType::class, array(
                    'label'         => false,
                    'entry_type'    => CompanyType::class,
                    'by_reference'  => false,
                    'allow_delete'  => true,
                    'allow_add'     => true,
                ))
                ->add('messages', CollectionType::class, array(
                    'label'         => false,
                    'entry_type'    => MessageType::class,
                    'by_reference'  => false,
                    'allow_delete'  => true,
                    'allow_add'     => true,
                ))
                ->add('save', SubmitType::class, array(
                    'label'     => 'Cotizar',
                    'attr'      => array('class' => 'btn btn-primary'),
                ));

    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Member'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_member';
    }


}
