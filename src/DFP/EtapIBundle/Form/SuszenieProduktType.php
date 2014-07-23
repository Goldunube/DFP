<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuszenieProduktType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pylosuchoscTemperaturaOtoczenie')
            ->add('pylosuchoscCzasOtoczenie')
            ->add('dotykTemperaturaOtoczenie')
            ->add('dotykCzasOtoczenie')
            ->add('utwardzenieTemperaturaOtoczenie')
            ->add('utwardzenieCzasOtoczenie')
            ->add('wstepneTemperaturaKabina')
            ->add('wstepneCzasKabina')
            ->add('doceloweTemperaturaKabina')
            ->add('doceloweCzasKabina')
            ->add('infrared')
            ->add('ultraviolet')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\SuszenieProdukt'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_suszenieprodukt';
    }
}
