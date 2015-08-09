<?php

namespace GCSV\TechnicalBundle\Form;

use Doctrine\ORM\EntityRepository;
use GCSV\CustomerBundle\Entity\Firma;
use GCSV\CustomerBundle\Entity\Oddzial;
use GCSV\TechnicalBundle\EventListener\OpisZdarzeniaTechnicznegoSubscriber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Form\FormInterface;

class ZdarzenieTechniczneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('rodzajZdarzeniaTechnicznego',null,array(
                    'label'         =>  'Rodzaj',
                    'required'      =>  true,
                    'attr'          =>  array('autocomplete'=>'off'),
                    'empty_value'   =>  '<<< wybierz rodzaj zdarzenia >>>'
                )
            )
            ->add('oddzialFirmy','gcsv_firma_oddzial_autocomplete',array(
                    'label'         =>  'Klient (oddział)',
                    'required'      =>  false,
                    'attr'          =>  array('autocomplete'=>'off'),
                )
            )
            ->add('dlugoscGeo','hidden',array(
                    'attr'          =>  array('autocomplete'=>'off')
                )
            )
            ->add('szerokoscGeo','hidden',array(
                    'attr'          =>  array('autocomplete'=>'off')
                )
            )
            ->add('priorytet','choice',array(
                    'choices'       =>  array(
                        -1  =>  'Niski',
                        0   =>  'Normalny',
                        1   =>  'Wysoki'
                    ),
                    'data'  =>  0,
                    'multiple'  =>  false,
                    'expanded'  =>  true
                )
            )
            ->add('osobaZlecajaca',null,array(
                    'property'      =>  'imienazwisko',
                    'label'         =>  'Osoba zlecająca',
                    'query_builder' =>  function(EntityRepository $er)
                        {
                            return $er->createQueryBuilder('oz')
                                ->select('oz,m,k')
                                ->leftJoin('oz.magazyn','m')
                                ->leftJoin('oz.kalendarz','k')
                                ->orderBy('oz.imie','ASC');
                        }
                )
            )
            ->add('uczestnikZdarzeniaTechnicznego','collection',array(
                    'type'      =>  new UczestnikZdarzeniaTechnicznegoType(),
                    'label'     =>  'Technik / Technicy'
                )
            )
            ->add('opis',null,array(
                    'label' =>  'Opis',
                    'required'  =>  true
                )
            )
        ;

        $subscriber = new OpisZdarzeniaTechnicznegoSubscriber($builder->getFormFactory());
        $builder->addEventSubscriber($subscriber);
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'zdt';
    }
}