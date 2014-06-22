<?php

namespace DFP\EtapIBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SystemMalarskiType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('produkty','collection',array(
                    'type'          =>  'entity',
                    'options'       =>  array(
                        'class'         =>  'DFP\EtapIBundle\Entity\Produkt',
                        'required'      =>  true,
                        'query_builder' =>  function(EntityRepository $er)
                        {
                            return $er->createQueryBuilder('p')->orderBy('p.nazwaHandlowa','ASC');
                        },
                        'label'     =>  false
                    ),
                    'allow_add'     =>  true,
                    'allow_delete'  =>  true,
                    'label'         =>  false,
                    'by_reference'  =>  false
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
            'data_class' => 'DFP\EtapIBundle\Entity\SystemMalarski'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_systemmalarski';
    }
}
