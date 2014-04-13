<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaNotatkaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rodzaj','choice',array(
                    'choices'   =>  array(
                        1 => 'Wymagania klienta',
                        2 => 'Informacje handlowe',
                        3 => 'Harmonogram działań',
                        4 => 'Notatki z wizyt'
                    )
                ))
            ->add('tresc','textarea', array('label'=>'Treść','required'=>false))
//            ->add('status')
//            ->add('dataSporzadzenia')
//            ->add('koniecEdycji')
//            ->add('filia')
//            ->add('uzytkownik')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\FiliaNotatka'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filianotatka';
    }
}
