<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaDodatekType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produkt')
            ->add('opakowanie')
            ->add('jednostka','choice',array(
                    'choices'   =>  array(
                        'l'     =>  'Litry',
                        'kg'    =>  'Kilogramy',
                        'szt'   =>  'Sztuki'
                    ),
                    'preferred_choices' =>  array('l')
                )
            )
            ->add('cena','money', array(
                    'currency'  =>  'PLN'
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
            'data_class' => 'DFP\EtapIBundle\Entity\OfertaDodatek'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_ofertapdodatek';
    }
}
