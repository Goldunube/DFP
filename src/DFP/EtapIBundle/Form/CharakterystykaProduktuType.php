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
            ->add('polyskPodKatem',null,array(
                    'label' => 'Połysk pod kątem'
                )
            )
            ->add('czasDoPrzelakierowaniaMin',null,array(
                    'label' =>  'Minimalny czas do przelakierowania'
                )
            )
            ->add('czasDoPrzelakierowaniaMax',null,array(
                    'label' =>  'Maksymalny czas do przelakierowania'
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
