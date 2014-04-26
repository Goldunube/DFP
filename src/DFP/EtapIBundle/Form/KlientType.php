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
            ->add('stronaWWW','url', array(
                    'label'     =>  'Adres strony WWW',
                    'required'  =>  false,
                    'attr'      =>  array(
                        'placeholder'   =>  'Poprawny adres WWW musi zaczynać się od frazy `http://` np. `http://www.csv.pl`',
                    )
                )
            )
            ->add('nip')
            ->add('kodMax')
            ->add('kanalDystrybucji')
            ->add('grupyKlientow', 'entity', array(
                    'label'     =>  'Grupa klientów',
                    'class'     =>  'DFPEtapIBundle:GrupaKlientow',
                    'property'  =>  'nazwaGrupy',
                    'multiple'  =>  true,
                    'expanded'  =>  true
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
