<?php

namespace GCSV\TechnicalBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerminZdarzeniaTechnicznegoHiddenDateTimeType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rozpoczecieWizyty','datetime_hidden',array(
                    'label'     =>  'Rozpoczęcie',
                )
            )
            ->add('zakonczenieWizyty','datetime_hidden',array(
                    'label'     =>  'Zakończenie',
                )
            )
            ->add('rozpoczecieWizytyWidget','datetime',array(
                    'attr'      =>  array(
                        'class'         =>  'datepicker',
                        'autocomplete'  =>  'off',
                    ),
                    'label'     =>  'Rozpoczęcie',
                    'widget'    =>  'single_text',
                    'mapped'    =>  false
                )
            )
            ->add('zakonczenieWizytyWidget','datetime',array(
                    'attr'      =>  array(
                        'class'         =>  'datepicker',
                        'autocomplete'  =>  'off',
                    ),
                    'label'     =>  'Zakończenie',
                    'widget'    =>  'single_text',
                    'mapped'    =>  false
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
            'data_class' => 'GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznego',
            'cascade_validation'    =>  true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'tzt';
    }
}
