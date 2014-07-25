<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DaneTechniczneProduktuType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('gestoscMIN',null,array('required'=>false))
            ->add('gestoscMAX',null,array('required'=>false))
            ->add('gestoscMieszaninyMIN',null,array('required'=>false))
            ->add('gestoscMieszaninyMAX',null,array('required'=>false))
            ->add('stopienRozdrobnieniaZiarnaMIN',null,array('required'=>false))
            ->add('stopienRozdrobnieniaZiarnaMAX',null,array('required'=>false))
            ->add('lepkoscFabrycznaStomerMIN',null,array('required'=>false))
            ->add('lepkoscFabrycznaStomerMAX',null,array('required'=>false))
            ->add('lepkoscFabrycznaFordMIN',null,array('required'=>false))
            ->add('lepkoscFabrycznaFordMAX',null,array('required'=>false))
            ->add('objZawartoscCzesciStalych',null,array('required'=>false))
            ->add('objZawartoscCzesciStalychMieszaniny',null,array('required'=>false))
            ->add('wagZawartoscCzesciStalych',null,array('required'=>false))
            ->add('wagZawartoscCzesciStalychMieszaniny',null,array('required'=>false))
            ->add('lzo','integer',array('required'=>false,'label'=>'LZO (VOC)'))
            ->add('lzoRFU','integer',array('required'=>false,'label'=>'LZO RFU (VOC RFU)'))
            ->add('rodzajProduktu')
            ->add('kolor')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\DaneTechniczneProduktu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_danetechniczneproduktu';
    }
}
