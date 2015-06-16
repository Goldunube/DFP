<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DoPobraniaType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',null,array('label'=>'Nagłówek'))
            ->add('content',null,array('label'=>'Treść'))
            ->add('publishedDate','datetime',array(
                    'label'     =>  'Od kiedy dostępny?',
                    'widget'    =>  'single_text',
                    'required'  =>  false
                )
            )
            ->add('allowedGroups','choice',array(
                    'label'     =>  'Widoczny dla...',
                    'choices'   =>  array(
                        'ROLE_TECHNIK'  =>  'techników',
                        'ROLE_HDFP'     =>  'handlowców DFP',
                        'ROLE_HWPS'     =>  'WPS',
                        'ROLE_FDFP'     =>  'freelancer\'ów',
                        'ROLE_RLS'      =>  'RLS\'ów',
                        'ROLE_RKS'      =>  'RKS\'ów',
                    ),
                    'multiple'  =>  true,
                    'expanded'  =>  true,
                    'required'  =>  false
                )
            )
            ->add('sort',null,array('label'=>'Kolejność'))
            ->add('zalacznik',new ZalacznikType())
            ->add('wiadomosciShow','choice',array(
                    'label'     =>  'Gdzie widoczny?',
                    'choices'   =>  array(
                        0       =>  'Tylko do pobrania',
                        2       =>  'Do pobrania oraz aktualności'
                    )
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
            'data_class' => 'DFP\EtapIBundle\Entity\DoPobrania'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_dopobrania';
    }
}
