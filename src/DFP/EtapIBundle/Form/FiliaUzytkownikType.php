<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FiliaUzytkownikType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('uzytkownik',null,array(
                    'query_builder' =>  function($repository) {return $repository->createQueryBuilder('u')->orderBy('u.imie','ASC');}
                )
            )
            ->add('poczatekPrzypisania','datetime', array(
                    'widget'        =>  'single_text',
                    'format'        =>  'yyyy-MM-dd HH:mm',
                    'attr'          =>  array('class'=>'dataczas'),
                ))
            ->add('koniecPrzypisania','datetime', array(
                    'widget'        =>  'single_text',
                    'format'        =>  'yyyy-MM-dd HH:mm',
                    'attr'          =>  array('class'=>'dataczas'),
                ))
            ->add('perm',null,array(
                    'required'      =>  false
                )
            );
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'DFP\EtapIBundle\Entity\FiliaUzytkownik'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_filiauzytkownik';
    }
}
