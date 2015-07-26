<?php

namespace GCSV\DniWolneBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TerminUrlopuType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('osoba',null,array(
                    'property'      =>  'imienazwisko',
                    'label'         =>  'Urlop dla ...',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return $er->createQueryBuilder('oz')
                                ->select('oz,m,k,g')
                                ->leftJoin('oz.magazyn','m')
                                ->leftJoin('oz.kalendarz','k')
                                ->leftJoin('oz.grupy','g')
                                ->where('g.id = 4')
                                ->orderBy('oz.imie','ASC');
                        },
                    'empty_value'   =>  '<<< wybierz osobę >>>'
                )
            )
            ->add('start','date',array(
                    'attr'          =>  array('class'=>'datepicker'),
                    'label'         =>  'Rozpoczęcie',
                    'widget'        =>  'single_text',
                )
            )
            ->add('koniec','date',array(
                    'attr'          =>  array('class'=>'datepicker'),
                    'label'         =>  'Zakończenie',
                    'widget'        =>  'single_text',
                )
            )
            ->add('typ','choice',array(
                    'label'         =>  'Rodzaj',
                    'choices'       =>  array(
                        1   =>  'Urlop wypoczynkowy',
                        2   =>  'Zwolnienie lekarskie'
                    )
                )
            )
            ->add('zatwierdzil',null,array(
                    'property'      =>  'imienazwisko',
                    'label'         =>  'Osoba zatwierdzająca',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return $er->createQueryBuilder('oz')
                                ->select('oz,m,k')
                                ->leftJoin('oz.magazyn','m')
                                ->leftJoin('oz.kalendarz','k')
                                ->orderBy('oz.imie','ASC');
                        },
                    'empty_value'   =>  '<<< wybierz osobę >>>'
                )
            )
            ->add('dataZgloszenia','datetime',array(
                    'attr'          =>  array('class'=>'datepicker'),
                    'label'         =>  'Data zgłoszenia',
                    'widget'        =>  'single_text',
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
            'data_class'    => 'GCSV\DniWolneBundle\Entity\TerminUrlopu',
            'novalidate'    =>  'novalidate'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_termin_urlopu';
    }
}
