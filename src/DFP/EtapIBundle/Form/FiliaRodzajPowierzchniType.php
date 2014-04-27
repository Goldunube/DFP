<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaRodzajPowierzchniType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rodzajPowierzchni',null,array(
                    'query_builder' =>  function($repository) {return $repository->createQueryBuilder('rp')->orderBy('rp.nazwa','ASC');}
                )
            )
            ->add('info',null,array('label'=>'Informacje dodatkowe'))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'DFP\EtapIBundle\Entity\FiliaRodzajPowierzchni'
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filiarodzajpowierzchni';
    }
}
