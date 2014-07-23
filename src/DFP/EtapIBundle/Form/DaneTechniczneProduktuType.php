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
            ->add('gestoscMIN','integer',array('required'=>false))
            ->add('gestoscMAX','integer',array('required'=>false))
            ->add('gestoscMieszaninyMIN','integer',array('required'=>false))
            ->add('gestoscMieszaninyMAX','integer',array('required'=>false))
            ->add('stopienRozdrobnieniaZiarnaMIN','integer',array('required'=>false))
            ->add('stopienRozdrobnieniaZiarnaMAX','integer',array('required'=>false))
            ->add('lepkoscFabrycznaStomerMIN','integer',array('required'=>false))
            ->add('lepkoscFabrycznaStomerMAX','integer',array('required'=>false))
            ->add('lepkoscFabrycznaFordMIN','integer',array('required'=>false))
            ->add('lepkoscFabrycznaFordMAX','integer',array('required'=>false))
            ->add('objZawartoscCzesciStalych','integer',array('required'=>false))
            ->add('objZawartoscCzesciStalychMieszaniny','integer',array('required'=>false))
            ->add('wagZawartoscCzesciStalych','integer',array('required'=>false))
            ->add('wagZawartoscCzesciStalychMieszaniny','integer',array('required'=>false))
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
