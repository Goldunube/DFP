<?php

namespace GCSV\TechnicalBundle\Form\Filter;

use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListaWizytFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id','filter_text', array(
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.id = :id')
                                    ->setParameter('id', $values['value']);
                            }
                        }
                )
            )
            ->add('rodzaj','filter_entity',array(
                    'class'     =>  'GCSV\TechnicalBundle\Entity\RodzajZdarzeniaTechnicznego',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('rzt.id = :idR')
                                    ->setParameter('idR', $values['value']);
                            }
                        }
                )
            )
            ->add('status','filter_choice',array(
                    'choices'   =>  array(
                        -2      =>  'Anulowana',
                        -1      =>  'Odrzucona',
                        0       =>  'Zgłoszona',
                        1       =>  'Zarezerwowana',
                        2       =>  'Zatwierdzona',
                        //3       =>  'Zrealizowana'
                    ),
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('zt.status = :idS')
                                    ->setParameter('idS', $values['value']);
                            }
                        }
                )
            )
            ->add('raport_tech','filter_choice',array(
                    'choices'   =>  array(
                        0       =>  'Bez raportu',
                        1       =>  'Z raportem',
                    ),
                    'multiple'  =>  false,
                    'expanded'  =>  true,
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){

                            }
                        }
                )
            )
            ->add('raport_zuz','filter_choice',array(
                    'choices'   =>  array(
                        0       =>  'Bez raportu',
                        1       =>  'Z raportem',
                    ),
                    'multiple'  =>  false,
                    'expanded'  =>  true,
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){

                            }
                        }
                )
            )
            ->add('klient','filter_text', array(
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('fi.nazwaSkrocona LIKE :nazwa')
                                    ->setParameter('nazwa', '%'.$values['value'].'%');
                            }
                        }
                )
            )
            ->add('zlecajacy','filter_entity',array(
                    'class'     =>  'GCSV\UserBundle\Entity\Uzytkownik',
                    'property'  =>  'imieNazwisko',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return $er->createQueryBuilder('ut')
                                ->select('ut,g,s,m')
                                ->leftJoin('ut.grupy','g')
                                ->leftJoin('ut.strefa','s')
                                ->leftJoin('ut.magazyn','m')
                                ->andWhere('ut.locked = false')
                                ->orderBy('ut.imie','ASC');
                        },
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('zt.osobaZlecajaca = :idZ')
                                    ->setParameter('idZ', $values['value']);
                            }
                        }
                )
            )
            ->add('technik','filter_entity',array(
                    'class'     =>  'GCSV\UserBundle\Entity\Uzytkownik',
                    'property'  =>  'imieNazwisko',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return $er->createQueryBuilder('ut')
                                ->select('ut,g,s,m')
                                ->leftJoin('ut.grupy','g')
                                ->leftJoin('ut.strefa','s')
                                ->leftJoin('ut.magazyn','m')
                                ->where('g.nazwa = :technik')
                                ->setParameter('technik','Technik')
                                ->andWhere('ut.locked = false')
                                ->orderBy('ut.imie','ASC');
                        },
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('uzt.osoba = :idT')
                                    ->setParameter('idT', $values['value']);
                            }
                        }
                )
            )
            ->add('rozpoczecieWizyty','filter_date',array(
                    'widget'    =>  'single_text',
                    'format'    =>  'dd.MM.yyyy',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.rozpoczecieWizyty >= :dataRozp')
                                    ->setParameter('dataRozp', $values['value']);
                            }
                        }
                )
            )
            ->add('zakonczenieWizyty','filter_date',array(
                    'widget'    =>  'single_text',
                    'format'    =>  'dd.MM.yyyy',
                    'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                            if (!empty($values['value'])){
                                $qb = $filterQuery->getQueryBuilder();
                                $qb->andWhere('tzt.zakonczenieWizyty <= :dataZak')
                                    ->setParameter('dataZak', $values['value']);
                            }
                        }
                )
            );
    }

    public function getName()
    {
        return 'wizyty_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            ));
    }
}