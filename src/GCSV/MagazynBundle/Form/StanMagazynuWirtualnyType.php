<?php

namespace GCSV\MagazynBundle\Form;


use GCSV\MagazynBundle\Form\Type\ProduktType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class StanMagazynuWirtualnyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('produkt','produkt_typeahead');
        $builder->add('ilosc','number',array(
                'label'         =>  'Ilość',
                'grouping'      =>  ' ',
                'precision'     =>  2
            )
        );
        $builder->add('wartosc','money',array(
                'label'     =>  'Wartość',
                'currency'  =>  'pln',
                'grouping'  =>  ' '
            )
        );
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'GCSV\MagazynBundle\Entity\StanMagazynuWirtualny',
            )
        );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'stan_mag_wirt';
    }

} 