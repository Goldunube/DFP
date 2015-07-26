<?php

namespace GCSV\TechnicalBundle\Form;

use GCSV\TechnicalBundle\Form\Type\RodzajPytanieZdarzenieTechniczneType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RodzajZdarzeniaTechnicznegoType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa')
            ->add('opis')
            ->add('showOthers','choice',array(
                    'label'     =>  'Pokaż wszystkim',
                    'choices'   =>  array(
                        0       =>  'Nie',
                        1       =>  'Tak'
                    )
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
            'data_class' => 'GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_technicalbundle_rodzajzdarzeniatechnicznego';
    }
}
