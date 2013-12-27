<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfilDzialalnosciType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwaProfilu')
            ->add('zweryfikowany', 'choice', array(
                    'choices'=>array(
                        true=>'TAK',
                        false=>'NIE'
                    ),
                    'label'=>'Zweryfikowany',
                    'multiple'=>false,
                    'expanded'=>true,
                    'required'=>true,
                    'empty_value'=>false,
                    'data'=>1,
                )
            )
            ->add('submit','submit',array('label'=>'Utwórz'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\ProfilDzialalnosci'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_profildzialalnosci';
    }
}
