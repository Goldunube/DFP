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
            ->add('wojewodztwo', 'text', array(
                    'label'         =>  'Województwo:',
                    'attr'          =>  array(
                        'placeholder'   =>  'Wprowadź nazwę województwa'
                    )
                )
            )
            ->add('miejscowosc', 'text', array(
                    'label'         =>  'Miejscowość:',
                    'attr'          =>  array(
                        'placeholder'   =>  'Wprowadź nazwę miejscowości'
                    )
                )
            )
            ->add('kodPocztowy',null,array(
                    'label'         =>  'Kod pocztowy:',
                    'attr'  =>  array(
                        'class'         =>  'kod-pocztowy',
                        'placeholder'   =>  'Kod pocztowy'
                    ),
                    'required'  =>  true
                )
            )
            ->add('ulica',null,array(
                    'label'         =>  'Ulica:',
                    'attr'  =>  array(
                        'placeholder'   => 'Wprowadź nazwę ulicy bez podawania przedrostków typy "ul." / "al."'
                    )
                )
            )
            ->add('filiePracownicy', 'collection', array(
                    'type'          =>  new FiliaPracownikType(),
                    'label'         =>  'Osoby kontaktowe:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  true
                ))
//            ->add('aktywna')
            ->add('matlakDotychczas',null,array(
                    'label'         =>  'Stosowany system malarski:',
                    'required'      =>  false
                )
            )
            ->add('zuzycieMaterialow',null,array(
                    'label'         =>  'Wielkość zużycia:',
                    'required'      =>  false
                )
            )
            ->add('kolorystyka',null,array(
                    'label'         =>  'Kolorystyka:',
                    'required'      =>  false
                )
            )
            ->add('filieMaterialyUzupelniajace', 'collection', array(
                    'type'          =>  new FiliaMaterialUzupelniajacyType(),
                    'label'         =>  'Materiały uzupełniające:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
            ))
            ->add('adnotacja',null,array(
                    'label'         =>  'Adnotacja:',
                    'required'      =>  false
                )
            )
            ->add('profileDzialalnosci', 'entity', array(
                    'label'         =>  'Profile działalności:',
                    'class'         =>  'DFPEtapIBundle:ProfilDzialalnosci',
                    'query_builder' =>  function($repository) {return $repository->createQueryBuilder('pd')->orderBy('pd.nazwaProfilu','ASC');},
                    'multiple'      =>  true,
                    'expanded'      =>  true,
                    'required'      =>  true,
            ))
            ->add('filieProcesyPrzygotowaniaPowierzchni', 'collection', array(
                    'type'          =>  new FiliaProcesPrzygotowaniaPowierzchniType(),
                    'label'         =>  'Metoda przygotowania powierzchni:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
            ))
            ->add('filieProcesyAplikacji', 'collection', array(
                    'type'          =>  new FiliaProcesAplikacjiType(),
                    'label'         =>  'Metoda aplikacji farby:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
            ))
            ->add('filieWymaganiaProduktu', 'collection', array(
                    'type'          =>  new FiliaWymaganiaProduktuType(),
                    'label'         =>  'Parametry produktu obecnie stosowanego:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
            ))
            ->add('filieProcesyUtwardzaniaPowloki', 'collection', array(
                    'type'          => new FiliaProcesUtwardzaniaPowlokiType(),
                    'label'         => 'Parametry utwardzania powłoki:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
            ))
            ->add('filieWymaganiaPowloki', 'collection', array(
                    'type'          => new FiliaWymaganiaPowlokiType(),
                    'label'         => 'Wymagania powłoki lakierowej:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
            ))
            ->add('filieRodzajePowierzchni', 'collection', array(
                    'type'          => new FiliaRodzajPowierzchniType(),
                    'label'         => 'Rodzaj podłoża:',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
                    'required'      =>  false,
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
