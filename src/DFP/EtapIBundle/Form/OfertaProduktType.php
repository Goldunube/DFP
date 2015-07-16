<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaProduktType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('ceny','collection',array(
                    'type'  =>  new OfertaCenaType(),
                    'allow_add' => true,
                    'allow_delete'  =>  true,
                    'prototype' =>  true,
                    'prototype_name' =>  '__cena_name__',
                    'by_reference'  =>  false,
                )
            )
            ->add('produkt',null,array(

                )
            )
            ->add('opakowanieWartosc')
            ->add('opakowanieJednostka','choice',array(
                    'choices'   =>  array(
                        'l'     =>  'Litry',
                        'kg'    =>  'Kilogramy',
                        'szt'   =>  'Sztuki'
                    ),
                    'preferred_choices' =>  array('l')
                )
            )
            ->add('informacjeDodatkowe')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'DFP\EtapIBundle\Entity\OfertaProdukt',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_ofertaprodukt';
    }
}
