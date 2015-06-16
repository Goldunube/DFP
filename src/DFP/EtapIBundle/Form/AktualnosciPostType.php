<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AktualnosciPostType extends AbstractType
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
            ->add('przyklejony','choice',array(
                    'label'     =>  'Przyklejony',
                    'choices'   =>  array(
                        false   =>  'Nie',
                        true    =>  'Tak'
                    ),
                    'data'      =>  0,
                    'expanded'  =>  true,
                    'multiple'  =>  false
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
            'data_class' => 'DFP\EtapIBundle\Entity\DoPobrania'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_aktualnosci_post';
    }
}
