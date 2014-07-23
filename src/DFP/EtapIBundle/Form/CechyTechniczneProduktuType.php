<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CechyTechniczneProduktuType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wlasciwosciMechaniczne',null,array(
                    'label' =>  'Właściwości mechaniczne'
                )
            )
            ->add('wlasciwosciMechaniczneJednostka','choice',array(
                    'choices'               =>  array(0 => 'godziny', 1 => 'dni'),
                    'required'              =>  true,
                    'mapped'                =>  false,
                    'label'                 =>  false,
                )
            )
            ->add('testErichsen',null,array(
                    'label' =>  'Test Erichsen\'a',
                    'label_attr'  =>  array(
                        'data-toggle'       =>  'czyt. "Erichsiena"',
                        'data-placement'    =>  'bottom'
                    )
                )
            )
            ->add('udarnosc',null,array(
                    'label'         =>  'Udarność',
                    'label_attr'    =>  array(
                        'title'     =>  'Odporność na uderzenie.'
                    )
                )
            )
            ->add('probaMandrela',null,array(
                    'label'     =>  'Próba Mandrela'
                )
            )
            ->add('plastycznosc','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'Słaba',
                        1   =>  'Normalna',
                        2   =>  'Dobra',
                        3   =>  'Bardzo dobra'
                    ),
                    'label'         =>  'Plastyczność',
                    'empty_value'   =>  'Nieokreślona',
                    'empty_data'    =>  null
                )
            )
            ->add('odpornoscScieranie','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'Słaba',
                        1   =>  'Normalna',
                        2   =>  'Dobra',
                        3   =>  'Bardzo dobra'
                    ),
                    'label'         =>  'Odporność na ścieranie',
                    'empty_value'   =>  'Nieokreślona',
                    'empty_data'    =>  null
                )
            )
            ->add('odpornoscMedia','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'Benzyna',
                        1   =>  'Detergenty',
                        2   =>  'Oleje',
                        3   =>  'Oleje gorące',
                        4   =>  'Woda',
                        5   =>  'Inne'
                    ),
                    'label'         =>  'Odporność na media',
                    'expanded'  =>  true,
                    'multiple'  =>  true
                )
            )
            ->add('odpornoscMglaSolna',null,array(
                    'label' =>  'Odporność na mgłę solną'
                )
            )
            ->add('odpornoscParaWodna',null,array(
                    'label' =>  'Odporność na parę wodną'
                )
            )
            ->add('przyczepnosc','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'Gt0',
                        1   =>  'Gt1',
                        2   =>  'Gt2',
                        3   =>  'Gt3'
                    ),
                    'label'         =>  'Przyczepność',
                    'empty_value'   =>  'Nieokreślona',
                    'empty_data'    =>  null
                )
            )
            ->add('odpornoscOgien','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'M-0',
                        1   =>  'M-1',
                        2   =>  'M-2',
                        3   =>  'M-3'
                    ),
                    'label'         =>  'Rozprzestrzenianie się ognia',
                    'empty_value'   =>  'Nieokreślona',
                    'empty_data'    =>  null
                )
            )
            ->add('odpornoscKorozja','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'C1',
                        1   =>  'C2',
                        2   =>  'C3',
                        3   =>  'C4',
                        4   =>  'C5-I',
                        5   =>  'C5-M'
                    ),
                    'label'         =>  'Kategoria korozyjności',
                    'empty_value'   =>  'Nieokreślona',
                    'empty_data'    =>  null
                )
            )
            ->add('odpornoscUV','choice',array(
                    'required'      =>  false,
                    'choices'       =>  array(
                        0   =>  'Słaba',
                        1   =>  'Normalna',
                        2   =>  'Dobra',
                        3   =>  'Bardzo dobra'
                    ),
                    'label'         =>  'Odporność na promienie UV',
                    'empty_value'   =>  'Nieokreślona',
                    'empty_data'    =>  null
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
            'data_class' => 'DFP\EtapIBundle\Entity\CechyTechniczneProduktu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_cechytechniczneproduktu';
    }
}
