<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SuszenieProduktType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('pylosuchoscTemperaturaOtoczenie')
            ->add('pylosuchoscCzasOtoczenie')
            ->add('pylosuchoscCzasOtoczenieJednostka','choice',array(
                    'label'     =>  false,
                    'choices'   =>  array(
                        0   =>  'Sekund',
                        1   =>  'Minut',
                        2   =>  'Godzin'
                    ),
                    'mapped'    =>  false
                )
            )
            ->add('dotykTemperaturaOtoczenie')
            ->add('dotykCzasOtoczenie')
            ->add('dotykCzasOtoczenieJednostka','choice',array(
                    'label'     =>  false,
                    'choices'   =>  array(
                        0   =>  'Sekund',
                        1   =>  'Minut',
                        2   =>  'Godzin'
                    ),
                    'mapped'    =>  false
                )
            )
            ->add('utwardzenieTemperaturaOtoczenie')
            ->add('utwardzenieCzasOtoczenie')
            ->add('utwardzenieCzasOtoczenieJednostka','choice',array(
                    'label'     =>  false,
                    'choices'   =>  array(
                        0   =>  'Sekund',
                        1   =>  'Minut',
                        2   =>  'Godzin'
                    ),
                    'mapped'    =>  false
                )
            )
            ->add('wstepneTemperaturaKabina')
            ->add('wstepneCzasKabina')
            ->add('wstepneCzasKabinaJednostka','choice',array(
                    'label'     =>  false,
                    'choices'   =>  array(
                        0   =>  'Sekund',
                        1   =>  'Minut',
                        2   =>  'Godzin'
                    ),
                    'mapped'    =>  false
                )
            )
            ->add('doceloweTemperaturaKabina')
            ->add('doceloweCzasKabina')
            ->add('doceloweCzasKabinaJednostka','choice',array(
                    'label'     =>  false,
                    'choices'   =>  array(
                        0   =>  'Sekund',
                        1   =>  'Minut',
                        2   =>  'Godzin'
                    ),
                    'mapped'    =>  false
                )
            )
            ->add('infrared','integer',array(
                    'label'     =>  'Suszenie IR (Podczerwień)',
                    'required'  =>  false
                )
            )
            ->add('ultraviolet','integer',array(
                    'label'     =>  'Suszenie UV (Ultrafiolet)',
                    'required'  =>  false
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
            'data_class' => 'DFP\EtapIBundle\Entity\SuszenieProdukt'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_suszenieprodukt';
    }
}
