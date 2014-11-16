<?php

namespace DFP\EtapIBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaCenaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('kolor')
            ->add('wartosc')
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'DFP\EtapIBundle\Model\OfertaCena',
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_ofertacena';
    }
} 