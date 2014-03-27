<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KlientType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwaPelna')
            ->add('nazwaSkrocona')
            ->add('nip')
            ->add('kodMax')
            ->add('kanalDystrybucji')
            ->add('grupyKlientow', 'entity', array(
                    'label'     =>  'Grupa klientów',
                    'class'     =>  'DFPEtapIBundle:GrupaKlientow',
                    'property'  =>  'nazwaGrupy',
                    'multiple'  =>  true,
                    'expanded'  =>  false
                )
            )
            ->add('filie', 'collection', array(
                    'type'      =>  new FiliaType(),
                    'label'     =>  false,
                    'options'   => array('label' => false),
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
            'data_class' => 'DFP\EtapIBundle\Entity\Klient'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_klient';
    }
}
