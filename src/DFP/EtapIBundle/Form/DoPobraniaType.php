<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DoPobraniaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array('label'=>'Nagłówek'))
            ->add('content',null,array('label'=>'Treść'))
            ->add('publishedDate','datetime',array(
                    'label'     =>  'Od kiedy dostępny?',
                    'widget'    =>  'single_text',
                    'required'  =>  false
                )
            )
            ->add('allowedGroups','choice',array(
                    'label'     =>  'Widoczny dla...',
                    'choices'   =>  array(
                        'ROLE_DYR'  =>  'Dyrektor',
                        'ROLE_KP'   =>  'Kierownik produktu',
                        'ROLE_KDFP' =>  'Koordynator DFP',
                        'ROLE_HDFP' =>  'Handlowiec DFP'
                    ),
                    'multiple'  =>  true,
                    'expanded'  =>  true,
                    'required'  =>  false
                )
            )
            ->add('zalacznik',new ZalacznikType())
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\DoPobrania'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_dopobrania';
    }
}
