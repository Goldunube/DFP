<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaPracownikType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie')
            ->add('nazwisko')
            ->add('email','email')
            ->add('stanowisko')
            ->add('telefon1',null,array(
                    'label' =>  'Telefon stacjonarny',
                    'attr'  =>  array('class' =>  'tel-stacjonarny')
                )
            )
            ->add('mobile',null,array(
                    'label' =>  'Telefon komórkowy',
                    'attr'  =>  array('class' =>  'tel-komorkowy')
                )
            )
            ->add('osobaKontaktowa','checkbox',array(
                'required'      => false
            ))
            ->add('notatka');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'DFP\EtapIBundle\Entity\FiliaPracownik'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filiapracownik';
    }
}
