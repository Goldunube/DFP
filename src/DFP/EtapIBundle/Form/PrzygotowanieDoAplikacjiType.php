<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrzygotowanieDoAplikacjiType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('przyspieszacz')
            ->add('antygrafiti')
            ->add('pastaMatujaca')
            ->add('dodatki')
            ->add('strukturyzator')
            ->add('tix')
            ->add('zywotnoscMieszaniny')
            ->add('lepkoscStomerMIN')
            ->add('lepkoscStomerMAX')
            ->add('lepkoscFordMIN')
            ->add('lepkoscFordMAX')
            ->add('zalecanaGruboscPowlokiSucho')
            ->add('zalecanaGruboscPowlokiMokro')
            ->add('nominalnaGruboscPowlokiSucho')
            ->add('nominalnaGruboscPowlokiMokro')
            ->add('punktRosy')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\PrzygotowanieDoAplikacji'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_przygotowaniedoaplikacji';
    }
}
