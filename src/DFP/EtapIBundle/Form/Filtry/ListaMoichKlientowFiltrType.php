<?php

namespace DFP\EtapIBundle\Form\Filtry;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;

class ListaMoichKlientowFiltrType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nazwa_klienta','filter_text', array(
                    'label' =>  'Nazwa klienta',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('kli.nazwaPelna LIKE :nazwa')
                                    ->setParameter('nazwa', '%'.$values['value'].'%');
                            }
                        }
                )
            )
            ->add('kod_max','filter_text', array(
                    'label' =>  'Kod MAX',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('kli.kodMax = :kodMax')
                                    ->setParameter('kodMax', $values['value']);
                            }
                        }
                )
            )
            ->add('adres','filter_text', array(
                    'label' =>  'Adres',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('kli.kodMax = :kodMax')
                                    ->setParameter('kodMax', $values['value']);
                            }
                        }
                )
            )
            ->add('profil','filter_text', array(
                    'label' =>  'Profil działalności',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('kli.kodMax = :kodMax')
                                    ->setParameter('kodMax', $values['value']);
                            }
                        }
                )
            );
    }

    public function getName()
    {
        return 'lista_moich_klientow_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            ));
    }
} 