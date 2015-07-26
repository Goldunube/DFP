<?php

namespace GCSV\RaportBundle\Form;

use GCSV\MagazynBundle\Form\Transformer\ProduktToIndeksTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaportZuzyciaProduktType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produkt','entity_hidden',array(
                    'class' =>  'GCSV\MagazynBundle\Entity\Produkt'
                )
            )
            ->add('iloscZuzyta',null,array('label'=>'Ilość zużyta'))
            ->add('iloscZostawiona',null,array('label'=>'Ilość pozostawiona'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GCSV\RaportBundle\Entity\RaportZuzyciaProdukt'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_rapzuzprod';
    }
}
