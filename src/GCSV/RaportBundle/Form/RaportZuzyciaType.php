<?php

namespace GCSV\RaportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaportZuzyciaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('raportZuzyciaProdukty','collection',array(
                    'type'  =>  new RaportZuzyciaProduktType(),
                    'by_reference'  =>  false,
                )
            )
            ->add('uwagi')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GCSV\RaportBundle\Entity\RaportZuzycia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_rapzuz';
    }
}
