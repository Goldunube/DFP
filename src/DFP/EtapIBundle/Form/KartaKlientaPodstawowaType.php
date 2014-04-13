<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KartaKlientaPodstawowaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nip', 'text', array('label'=> 'NIP'))
            ->add('nazwaPelna', 'text', array('label'=>'Pełna nazwa'))
            ->add('nazwaSkrocona', 'text', array('label'=>'Skrócona nazwa'))
            ->add('grupyKlientow', 'entity', array(
                    'label'     =>  'Grupa klientów',
                    'class'     =>  'DFPEtapIBundle:GrupaKlientow',
                    'property'  =>  'nazwaGrupy',
                    'multiple'  =>  true,
                    'expanded'  =>  true
                )
            )
            ->add('filie', 'collection', array(
                    'type'  =>  new FiliaType(),
                    'label' =>  'Filia',
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
