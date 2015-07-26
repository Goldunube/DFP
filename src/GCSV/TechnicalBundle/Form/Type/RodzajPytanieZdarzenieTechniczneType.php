<?php

namespace GCSV\TechnicalBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RodzajPytanieZdarzenieTechniczneType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wymagane')
            ->add('pytanie')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GCSV\TechnicalBundle\Entity\RodzajPytanieZdarzenieTechniczne'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_technicalbundle_rodzajpytaniezdarzenietechniczne';
    }
}
