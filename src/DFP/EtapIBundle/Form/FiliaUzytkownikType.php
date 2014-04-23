<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaUzytkownikType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uzytkownik')
            ->add('poczatekPrzypisania','datetime', array(
                    'widget'        =>  'single_text',
                    'format'        =>  'yyyy-MM-dd HH:mm',
                    'attr'          =>  array('class'=>'dataczas'),
                ))
            ->add('koniecPrzypisania','datetime', array(
                    'widget'        =>  'single_text',
                    'format'        =>  'yyyy-MM-dd HH:mm',
                    'attr'          =>  array('class'=>'dataczas'),
                ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\FiliaUzytkownik'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filiauzytkownik';
    }
}
