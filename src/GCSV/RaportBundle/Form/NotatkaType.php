<?php

namespace GCSV\RaportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class NotatkaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('publiczna',null,array(
                    'required'  =>  false
                )
            )
            ->add('rodzaj',null,array(
                    'attr'  =>  array(
                        'class'         =>  'typeahead',
                        'data-provide'  =>  'typeahead',
                        'autocomplete'  =>  'off'
                    ),
                )
            )
            ->add('tresc',null,array(
                    'label' =>  'Treść',
                    'attr'  =>  array(
                        'class' =>  'tinymce',
                        'data-theme' => 'raptech'
                    )
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
            'data_class' => 'GCSV\RaportBundle\Entity\Notatka'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_notatka';
    }
}
