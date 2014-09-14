<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduktType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producent','choice',array(
                    'choices'   =>  array(
                        0   =>  'GCSV',
                        1   =>  'BESA',
                    )
                )
            )
            ->add('nazwaHandlowa')
            ->add('nazwaTechniczna')
            ->add('kodFabrycznyProduktu')
            ->add('numerEdycjiBESA',null,array('label'=>'Numer edycji (BESA)'))
            ->add('numerEdycjiCSV',null,array('label'=>'Numer edycji (GCSV)'))
            ->add('grupaProduktow',null,array('label'=>'Grupa produktów'))
            ->add('grupaPromowania')
            ->add('cechyTechniczneProduktu', new CechyTechniczneProduktuType())
            ->add('zgodnoscNorm')
            ->add('daneTechniczne', new DaneTechniczneProduktuType())
            ->add('rodzajePowierzchni',null,array('required'=>false))
            ->add('przygotowaniePowierzchni',null,array(
                    'required'  =>  false,
                    'label'     =>  'Metody przygotowania powierzchni'
                )
            )
            ->add('przygotowaniePowierzchniUwagi',null,array(
                    'label'     =>  'Dane uzupełniające'
                )
            )
            ->add('metodyAplikacji',null,array('required'=>false))
            ->add('przygotowanieDoAplikacji', new PrzygotowanieDoAplikacjiType())
            ->add('suszenie', new SuszenieProduktType())
            ->add('charakterystykaProduktu', new CharakterystykaProduktuType())
            ->add('czasMagazynowania')
            ->add('magazynowanieOpis',null,array(
                    'label'     =>  'Sposób magazynowania'
                )
            )
            ->add('czasMagazynowaniaJednostka','choice',array(
                    'choices'               =>  array(
                        0 => 'miesiące', 1 => 'lata'
                    ),
                    'required'              =>  true,
                    'mapped'                =>  false,
                    'label'                 =>  false,
                )
            )
            ->add('certyfikaty')
            ->add('badania')
            ->add('opisPodstawowy')
            ->add('opisPelny',null,array(
                    'label' =>  'Opis pełny'
                )
            )
            ->add('uwagi',null,array(
                    'label' =>  'Uwagi ogólne'
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
            'data_class' => 'DFP\EtapIBundle\Entity\Produkt'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_produkt';
    }
}
