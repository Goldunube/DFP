<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaHandlowaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dataZlozeniaZamowienia')
            ->add('info')
            ->add('technik')
            ->add('koordynatorDFP')
            ->add('status')
            ->add('filia')
            ->add('zamawiajacy')
            ->add('ofertyProfileSystemy','collection',array(
                    'type'          =>  new OfertaHandlowaProfilSystemType(),
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'by_reference'  =>  false,
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
            'data_class' => 'DFP\EtapIBundle\Entity\OfertaHandlowa'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_ofertahandlowa';
    }
}
