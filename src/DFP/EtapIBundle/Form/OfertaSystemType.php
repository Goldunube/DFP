<?php

namespace DFP\EtapIBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OfertaSystemType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('warstwa1','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return  $er->createQueryBuilder('p')
                                ->leftJoin('p.grupaProduktow','gp')
                                ->where('gp.nazwa IN (:rodzaj)')
                                ->setParameter('rodzaj',array('Grunt','Gruntoemalia'));
                        },
                    'expanded'  =>  false,
                    'multiple'  =>  false,
                    'required'  =>  true,
                    'empty_value'    =>  '-- Wybierz produkt -- '
                )
            )
            ->add('warstwa2','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
//                    'query_builder' =>  function(EntityRepository $er)
//                        {
//                            return  $er->createQueryBuilder('p')
//                                ->leftJoin('p.grupaProduktow','gp')
//                                ->where('gp.nazwa = :rodzaj')
//                                ->setParameter('rodzaj','Międzywarstwa');
//                        },
                    'expanded'  =>  false,
                    'multiple'  =>  false,
                    'required'  =>  false
                )
            )
            ->add('warstwa3','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return  $er->createQueryBuilder('p')
                                ->leftJoin('p.grupaProduktow','gp')
                                ->where('gp.nazwa in (:rodzaj)')
                                ->setParameter('rodzaj',array('Farba nawierzchniowa','Międzywarstwa'));
                        },
                    'expanded'  =>  false,
                    'multiple'  =>  false,
                    'required'  =>  false
                )
            )
            ->add('warstwa4','entity',array(
                    'class' =>  'DFPEtapIBundle:Produkt',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return  $er->createQueryBuilder('p')
                                ->leftJoin('p.grupaProduktow','gp')
                                ->where('gp.nazwa = :rodzaj')
                                ->setParameter('rodzaj','Farba nawierzchniowa');
                        },
                    'expanded'  =>  false,
                    'multiple'  =>  false,
                    'required'  =>  false
                )
            )
            ->add('informacja')
            ->add('profil',null,array(
                    'required'  =>  true
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
            'data_class' => 'DFP\EtapIBundle\Entity\OfertaSystem'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_ofertasystem';
    }
}
