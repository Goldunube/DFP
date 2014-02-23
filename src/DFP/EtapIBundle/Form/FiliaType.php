<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaType extends AbstractType
{
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wojewodztwo', 'text', array('label' => 'Województwo'))
            ->add('miejscowosc', 'text', array('label' => 'Miejscowość'))
            ->add('kodPocztowy')
            ->add('ulica')
            ->add('aktywna')
            ->add('matlakDotychczas')
            ->add('zuzycieMaterialow')
            ->add('adnotacja')
            ->add('profileDzialalnosci', 'entity', array(
                    'label'     =>  'Profil działalności',
                    'class'     =>  'DFPEtapIBundle:ProfilDzialalnosci',
                    'property'  =>  'nazwaProfilu',
                    'multiple'  =>  true,
                    'expanded'  =>  true,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\Filia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filia';
    }
}
