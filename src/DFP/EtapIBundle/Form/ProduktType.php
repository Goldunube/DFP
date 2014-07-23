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
            ->add('nazwaHandlowa')
            ->add('nazwaTechniczna')
            ->add('kodFabrycznyProduktu')
            ->add('grupaProduktow',null,array('label'=>'Grupa produktów'))
            ->add('grupaPromowania')
            ->add('cechyTechniczneProduktu', new CechyTechniczneProduktuType())
            ->add('zgodnoscNorm')
            ->add('daneTechniczne', new DaneTechniczneProduktuType())
            ->add('rodzajePowierzchni')
            ->add('przygotowaniePowierzchni')
            ->add('metodyAplikacji')
            ->add('przygotowanieDoAplikacji', new PrzygotowanieDoAplikacjiType())
            ->add('suszenie', new SuszenieProduktType())
            ->add('charakterystykaProduktu', new CharakterystykaProduktuType())
            ->add('produktyUtwardzacze')
            ->add('produktyRozcienczalniki')
            ->add('czasMagazynowania')
            ->add('certyfikaty')
            ->add('badania')
            ->add('opisPodstawowy')
            ->add('opisPelny')
            ->add('uwagi')
//            ->add('systemyMalarskie')
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
