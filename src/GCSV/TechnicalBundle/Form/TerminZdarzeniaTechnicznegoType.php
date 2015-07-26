<?php

namespace GCSV\TechnicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerminZdarzeniaTechnicznegoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rozpoczecieWizyty',null,array(
                    'attr'      =>  array('class'=>'datepicker'),
                    'label'     =>  'Rozpoczęcie',
                    'widget'        =>  'single_text',
                )
            )
            ->add('zakonczenieWizyty',null,array(
                    'attr'      =>  array('class'=>'datepicker'),
                    'label'     =>  'Zakończenie',
                    'widget'        =>  'single_text',
                )
            )
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_technicalbundle_terminzdarzeniatechnicznego';
    }
}
