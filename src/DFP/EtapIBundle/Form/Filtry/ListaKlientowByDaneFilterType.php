<?php

namespace DFP\EtapIBundle\Form\Filtry;


use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListaKlientowByDaneFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nip','filter_text',array(
                    'label' =>  'NIP'
                )
            )
            ->add('skrotNazwy','filter_text',array(
                    'label' =>  'Skrót nazwy',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('k.nazwaSkrocona LIKE :nazwa')
                                    ->setParameter('nazwa', '%'.$values['value'].'%');
                            }
                        }
                )
            )
            ->add('kodMax','filter_text',array(
                    'label' =>  'Kod MAX',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('k.kodMax LIKE :kod')
                                    ->setParameter('kod', '%'.$values['value'].'%');
                            }
                        }
                )
            );
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'lista_klientow_dane_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            ));
    }
} 