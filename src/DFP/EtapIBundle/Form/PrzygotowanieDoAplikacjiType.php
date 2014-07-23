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
            ->add('przyspieszacz',null,array('label'=>'Przyspieszacz'))
            ->add('antygrafiti','choice',array(
                    'required'      =>  true,
                    'choices'       =>  array(
                        0   =>  'Nie',
                        1   =>  'Tak',
                        2   =>  'Tak, zamiast rozcieńczalnika',
                    ),
                    'label'         =>  'Dodatek antygrafiti',
                )
            )
            ->add('pastaMatujaca',null,array('label'=>'Pasta matująca'))
            ->add('dodatki',null,array('label'=>'Inne dodatki'))
            ->add('strukturyzator')
            ->add('tix',null,array('label'=>'TIX'))
            ->add('zywotnoscMieszaniny',null,array('label'=>'Czas życia mieszaniny'))
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
