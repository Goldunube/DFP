<?php

namespace DFP\EtapIBundle\Form;

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
            ->add('kodPocztowy')
            ->add('ulica')
//            ->add('aktywna')
            ->add('matlakDotychczas')
            ->add('zuzycieMaterialow')
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
                    'label'         =>  'Procesy przygotowania powierzchni',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieProcesyAplikacji', 'collection', array(
                    'type'          =>  new FiliaProcesAplikacjiType(),
                    'label'         =>  'Procesy aplikacji',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieWymaganiaProduktu', 'collection', array(
                    'type'          =>  new FiliaWymaganiaProduktuType(),
                    'label'         =>  'Wymagania produktu',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieProcesyUtwardzaniaPowloki', 'collection', array(
                    'type'          => new FiliaProcesUtwardzaniaPowlokiType(),
                    'label'         => 'Procesy utwardzania powłoki',
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
            ))
            ->add('filieWymaganiaPowloki', 'collection', array(
                    'type'          => new FiliaWymaganiaPowlokiType(),
                    'label'         => 'Wymagania powłoki',
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
