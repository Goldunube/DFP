<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaProcesUtwardzaniaPowlokiType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('procesUtwardzaniaPowloki', null, array(
                    'query_builder' =>  function($repository) {return $repository->createQueryBuilder('pup')->orderBy('pup.nazwaProcesu','ASC');},
                )
            )
            ->add('tempMin',null,array('label'=>'Temperatura MIN', 'attr'=> array('class'=>'input-temp')))
            ->add('tempMax',null,array('label'=>'Temperatura MAX', 'attr'=> array('class'=>'input-temp')))
            ->add('czasSchniecia',null,array('label'=>'Czas schnięcia', 'attr'=> array('class'=>'input-czas')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\FiliaProcesUtwardzaniaPowloki'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filiaprocesutwardzaniapowloki';
    }
}
