<?php

namespace DFP\EtapIBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduktUtwardzaczType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('proporcjaMieszaniaObjetosciowo')
            ->add('proporcjaMieszaniaWagowo')
            ->add('utwardzacz','entity',array(
                    'class'             =>  'DFP\EtapIBundle\Entity\Produkt',
                    'query_builder'     =>  function(EntityRepository $er)
                    {
                        return $er->createQueryBuilder('p')
                            ->select('p,gp')
                            ->leftJoin('p.grupaProduktow','gp')
                            ->where('gp.nazwa = :nazwa')
                            ->setParameter('nazwa','Utwardzacz');
                    }
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
            'data_class' => 'DFP\EtapIBundle\Entity\ProduktUtwardzacz'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_produktutwardzacz';
    }
}
