<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CharakterystykaProduktuType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('wydajnoscTeoretyczna','integer',array(
                    'label'     =>  'Wydajność teoretyczna',
                    'required'  =>  false
                )
            )
            ->add('zuzycieTeoretyczne','integer',array(
                    'label'     =>  'Zużycie teoretyczne',
                    'required'  =>  false
                )
            )
            ->add('wydajnoscPraktyczna','integer',array(
                    'label'     =>  'Wydajność praktyczna',
                    'required'  =>  false
                )
            )
            ->add('zuzyciePraktyczne','integer',array(
                    'label'     =>  'Zużycie praktyczne',
                    'required'  =>  false
                )
            )
            ->add('polyskPodKatem',null,array(
                    'label' => 'Połysk pod kątem'
                )
            )
            ->add('czasDoPrzelakierowania',null,array(
                    'label' =>  'Czas do przelakierowania'
                )
            )
            ->add('uwagi')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\CharakterystykaProduktu'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_charakterystykaproduktu';
    }
}
