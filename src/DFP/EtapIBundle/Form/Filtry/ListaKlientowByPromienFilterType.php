<?php

namespace DFP\EtapIBundle\Form\Filtry;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListaKlientowByPromienFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('miejscowosc','filter_text',array(
                    'label' =>  'Miejscowość'
                )
            )
            ->add('promien','filter_number',array(
                    'label' =>  'Promień poszukiwań',
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
        return 'lista_klientow_promien_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            ));
    }
}