<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaProcesPrzygotowaniaPowierzchniType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('procesPrzygotowaniaPowierzchni',null,array(
                    'query_builder' =>  function($repository) {return $repository->createQueryBuilder('ppp')->orderBy('ppp.nazwaProcesu','ASC');},
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
            'data_class' => 'DFP\EtapIBundle\Entity\FiliaProcesPrzygotowaniaPowierzchni'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filiaprocesprzygotowaniapowierzchni';
    }
}
