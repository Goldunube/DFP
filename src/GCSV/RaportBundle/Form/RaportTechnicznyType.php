<?php

namespace GCSV\RaportBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RaportTechnicznyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cel')
            ->add('tempOtoczenia')
            ->add('wilgotnosc')
            ->add('tempPodloza')
            ->add('punktRosy')
            ->add('tempGruntu')
            ->add('tempMiedzywarstwy')
            ->add('tempFarbyNawierzchniowej')
            ->add('roznicaTemperaturPodloza')
            ->add('systemMalarski')
            ->add('przygotowaniePowierzchni')
            ->add('apliHydro')
            ->add('apliElektro')
            ->add('apliPisto')
            ->add('aplikacjaInne')
            ->add('rodzajMalowanejPowierzchni')
            ->add('rodzajElementu')
            ->add('gruboscNaMokro')
            ->add('przerwaNaOdparowanie')
            ->add('gruboscMiedzywarstwy')
            ->add('przerwaNaOdparowanieMiedzywarstwy')
            ->add('gruboscNawierzchniNaMokro')
            ->add('odparowanie')
            ->add('suszenie')
            ->add('wykonanePrace')
            ->add('wnioski')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GCSV\RaportBundle\Entity\RaportTechniczny'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_raportbundle_raporttechniczny';
    }
}
