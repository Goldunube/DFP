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
            ->add('imie',null,array(
                    'attr'          =>  array(
                        'placeholder'   =>  'Wprowadź imię'
                    )
                )
            )
            ->add('nazwisko',null,array(
                    'attr'          =>  array(
                        'placeholder'   =>  'Wprowadź nazwisko'
                    )
                )
            )
            ->add('email','email',array(
                    'attr'          =>  array(
                        'placeholder'   =>  'Jeżeli nie znasz wprowadź: nazwaklienta@test.pl'
                    )
                )
            )
            ->add('stanowisko',null,array(
                    'attr'          =>  array(
                        'placeholder'   =>  'Wprowadź stanowisko'
                    )
                )
            )
            ->add('telefon1',null,array(
                    'label' =>  'Telefon stacjonarny',
                    'attr'  =>  array(
                        'class'         =>  'tel-stacjonarny',
                        'placeholder'   =>  'Wprowadź numer w formacie (000) 000-00-00'
                    )
                )
            )
            ->add('mobile',null,array(
                    'label' =>  'Telefon komórkowy',
                    'attr'  =>  array(
                        'class' =>  'tel-komorkowy',
                        'placeholder'   =>  'Wprowadź numer w formacie 0-000-000-000'
                    )
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
