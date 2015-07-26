<?php

namespace GCSV\TechnicalBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UczestnikZdarzeniaTechnicznegoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('osoba',null,array(
                    'property'  =>  'imienazwiskospecjalizacja',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            $query = $er->createQueryBuilder('uzt')
                                ->select('uzt,g,s,k,m')
                                ->leftJoin('uzt.grupy','g')
                                ->leftJoin('uzt.specjalizacje','s')
                                ->leftJoin('uzt.kalendarz','k')
                                ->leftJoin('uzt.magazyn','m')
                                ->where('g.id = 4')
                                ->andWhere('uzt.showCalendar = true')
                                ->orderBy('uzt.imie', 'ASC');
                            return $query;
                        },
                    'empty_value'   =>  '<<< wskaż technika >>>',
                    'attr'          =>  array('autocomplete'=>'off'),
                )
            )
            ->add('terminy','collection',array(
                    'type'      =>  new TerminZdarzeniaTechnicznegoType()
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
            'data_class' => 'GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_technicalbundle_uczestnikzdarzeniatechnicznego';
    }
}
