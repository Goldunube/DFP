<?php

namespace DFP\EtapIBundle\Form;

use DFP\EtapIBundle\Entity\FiliaMaterialUzupelniajacy;
use DFP\EtapIBundle\Entity\FiliaPracownik;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaType extends AbstractType
{
    /**
    * @param FormBuilderInterface $builder
    * @param array $options
    */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wojewodztwo', 'text', array('label' => 'Województwo'))
            ->add('miejscowosc', 'text', array('label' => 'Miejscowość'))
            ->add('kodPocztowy',null,array(
                    'attr'  =>  array(
                        'class' =>  'kod-pocztowy'
                    ),
                    'required'  =>  false
                )
            )
            ->add('ulica')
            ->add('filiePracownicy', 'collection', array(
                    'type'          =>  new FiliaPracownikType(),
                    'label'         =>  'Osoby kontaktowe',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                ))
//            ->add('aktywna')
            ->add('matlakDotychczas')
            ->add('zuzycieMaterialow')
            ->add('kolorystyka')
            ->add('filieMaterialyUzupelniajace', 'collection', array(
                    'type'          =>  new FiliaMaterialUzupelniajacyType(),
                    'label'         =>  'Materiały uzupełniające',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('adnotacja')
            ->add('profileDzialalnosci', 'entity', array(
                    'label'     =>  'Profil działalności',
                    'class'     =>  'DFPEtapIBundle:ProfilDzialalnosci',
                    'property'  =>  'nazwaProfilu',
                    'multiple'  =>  true,
                    'expanded'  =>  true,
            ))
            ->add('filieProcesyPrzygotowaniaPowierzchni', 'collection', array(
                    'type'          =>  new FiliaProcesPrzygotowaniaPowierzchniType(),
                    'label'         =>  'Metoda przygotowania powierzchni',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieProcesyAplikacji', 'collection', array(
                    'type'          =>  new FiliaProcesAplikacjiType(),
                    'label'         =>  'Metoda aplikacji farby',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieWymaganiaProduktu', 'collection', array(
                    'type'          =>  new FiliaWymaganiaProduktuType(),
                    'label'         =>  'Parametry produktu obecnie stosowanego',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieProcesyUtwardzaniaPowloki', 'collection', array(
                    'type'          => new FiliaProcesUtwardzaniaPowlokiType(),
                    'label'         => 'Parametry utwardzania powłoki',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieWymaganiaPowloki', 'collection', array(
                    'type'          => new FiliaWymaganiaPowlokiType(),
                    'label'         => 'Wymagania powłoki lakierowej',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieRodzajePowierzchni', 'collection', array(
                    'type'          => new FiliaRodzajPowierzchniType(),
                    'label'         => 'Rodzaj podłoża',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\Filia'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filia';
    }
}
