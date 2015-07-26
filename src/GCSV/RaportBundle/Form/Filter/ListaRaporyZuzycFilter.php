<?php

namespace GCSV\RaportBundle\Form\Filter;


use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\Query\QueryInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ListaRaporyZuzycFilter extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('id','filter_text',array(
                'label' =>  'ID raportu'
            )
        );
        $builder->add('zdarzenieTechniczne','filter_text',array(
                'label' =>  'ID zdarzenia'
            )
        );
        $builder->add('autor','filter_entity',array(
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
            )
        );
        $builder->add('wydruk','filter_choice',array(
                'choices'   =>  array(
                    true       =>  'Wydrukowane',
                    false       =>  'Niewydrukowane',
                ),
                'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                    if (isset($values['value'])){
                        $qb = $filterQuery->getQueryBuilder();
                        $qb->andWhere('rz.wydruk = :status')
                            ->setParameter('status', $values['value']);
                    }
                },
            )
        );
        $builder->add('status','filter_choice',array(
                'choices'   =>  array(
                    true       =>  'Zaakceptowane',
                    false       =>  'Niezaakceptowane',
                ),
                'apply_filter' => function(QueryInterface $filterQuery, $field, $values){
                    if (isset($values['value'])){
                        $qb = $filterQuery->getQueryBuilder();
                        $qb->andWhere('rz.akceptacja = :status')
                            ->setParameter('status', $values['value']);
                    }
                },
            )
        );
        $builder->add('dataUtworzenia','filter_date_range',array(
                'left_date_options' => array(
                    'widget'        =>  'single_text',
                    'attr'          =>  array(
                        'placeholder'   =>  'Data od'
                    ),
                ),
                'right_date_options' => array(
                    'widget'    =>  'single_text',
                    'attr'          =>  array(
                        'placeholder'   =>  'Data do'
                    )
                ),
                'label' =>  'Data utworzenia'
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
        return 'raporty_zuzyc_filter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'csrf_protection'   => false,
                'validation_groups' => array('filtering')
            ));
    }

} 