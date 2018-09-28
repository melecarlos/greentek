<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class QuotationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('kwh',NumberType::class, array(
                    'label'     => 'Consumo mensual (kWh):',
                    'required'  => false,
                    'attr'      => array('class' => 'form-control')
                ))
                ->add('percentage', ChoiceType::class, array(
                    'label'     => 'Porcentaje de Ahorro',
                    'required'  => true,
                    'attr'      => array('class' => 'form-control'),
                    'choices'   => array(
                        'Seleccione el ahorro' => null,
                        '30%' => '30',
                        '50%' => '50',
                        '70%' => '70',
                        '90%' => '90'
                    ),
                ))
                ->add('installation', ChoiceType::class, array(
                    'label'     => 'Tipo de instalación *',
                    'required'  => true,
                    'attr'      => array('class' => 'form-control'),
                    'choices'  => array(
                        'Seleccione el tipo de instalación' => null,
                        'Residencial' => 'Residencial',
                        'Empresarial' => 'Empresarial'
                    ),
                ))
                ->add('kwp', HiddenType::class, array(
                    'label'     => false,
                    'required'  => false,
                    'attr'      => array('class' => 'form-control', 'readonly' => true)
                ));

    }
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Quotation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_quotation';
    }


}
