<?php

namespace GCSV\MagazynBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class UzytkownikStanMagazynuWirtualny
 * @package GCSV\MagazynBundle\Form
 */
class UzytkownikStanMagazynuWirtualnyType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('stanyMagazynoweWirtualne','collection',array(
                    'type'  => new StanMagazynuWirtualnyType(),
                    'by_reference'  =>  false,
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true
                )
            )
            ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'    =>  'GCSV\UserBundle\Entity\Uzytkownik'
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
        return 'uzytkownik_stan_mag_wirt';
    }

} 