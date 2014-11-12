<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaSystemType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('warstwa1','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'expanded'  =>  false,
                    'multiple'  =>  false
                )
            )
            ->add('warstwa2','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'expanded'  =>  false,
                    'multiple'  =>  false
                )
            )
            ->add('warstwa3','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'expanded'  =>  false,
                    'multiple'  =>  false
                )
            )
            ->add('warstwa4','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'expanded'  =>  false,
                    'multiple'  =>  false
                )
            )
            ->add('informacja')
            ->add('profil')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\OfertaSystem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_ofertasystem';
    }
}
