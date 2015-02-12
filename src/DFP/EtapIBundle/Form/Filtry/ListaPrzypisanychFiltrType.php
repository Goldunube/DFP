<?php

namespace DFP\EtapIBundle\Form\Filtry;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class ListaPrzypisanychFiltrType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa_klienta','filter_text', array(
                    'label' =>  'Nazwa klienta',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.id = :id')
                                    ->setParameter('id', $values['value']);
                            }
                        }
                )
            )
            ->add('kod_max','filter_text', array(
                    'label' =>  'Kod MAX',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.id = :id')
                                    ->setParameter('id', $values['value']);
                            }
                        }
                )
            )
            ->add('przypisany','filter_text', array(
                    'label' =>  'Osoba przypisana',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.id = :id')
                                    ->setParameter('id', $values['value']);
                            }
                        }
                )
            )
            ->add('dostep','filter_choice', array(
                    'label' =>  'Status',
                    'choices'   =>  array(
                        0   =>  'Tylko zablokowani',
                        1   =>  'Tylko odblokowani'
                    ),
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.id = :id')
                                    ->setParameter('id', $values['value']);
                            }
                        }
                )
            );
    }

    public function getName()
    {
        return 'lista_przypisanych_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            ));
    }
} 