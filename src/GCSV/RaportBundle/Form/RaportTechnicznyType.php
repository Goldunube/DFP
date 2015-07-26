<?php

namespace GCSV\RaportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaportTechnicznyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cel')
            ->add('tresc',null,array(
                    'label' =>  'Treść',
                    'attr'  =>  array(
                        'class' =>  'tinymce',
                        'data-theme' => 'raptech'
                    )
                )
            )
            ->add('zalecenia',null,array(
                    'attr'  =>  array(
                        'class' =>  'tinymce',
                        'data-theme' => 'raptech'
                    )
                )
            )
            ->add('typ',null,array(
                    'required'  =>  true
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
            'data_class' => 'GCSV\RaportBundle\Entity\RaportTechniczny'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_raportbundle_raporttechniczny';
    }
}
