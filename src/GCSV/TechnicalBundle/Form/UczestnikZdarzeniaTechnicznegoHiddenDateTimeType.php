<?php

namespace GCSV\TechnicalBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UczestnikZdarzeniaTechnicznegoHiddenDateTimeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('osoba',null,array(
                    'property'  =>  'imienazwisko',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            $query = $er->createQueryBuilder('uzt')
                                ->select('uzt,p')
                                ->leftJoin('uzt.profilUzytkownika','p')
                                ->where('p.pokazKalendarz = true')
                                ->orderBy('uzt.imie', 'ASC');
                            return $query;
                        },
                    'empty_value'   =>  '<<< wskaż technika / technologa / kierownika produktu >>>',
                    'attr'          =>  array('autocomplete'=>'off'),
                )
            )
            ->add('terminy','collection',array(
                    'type'      =>  new TerminZdarzeniaTechnicznegoHiddenDateTimeType(),
                    'cascade_validation'    =>  true
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
            'data_class' => 'GCSV\TechnicalBundle\Entity\UczestnikZdarzeniaTechnicznego',
            'cascade_validation'    =>  true
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'uzt';
    }
}
