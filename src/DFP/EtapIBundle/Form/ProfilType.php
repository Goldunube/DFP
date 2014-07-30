<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfilType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plec','choice',array(
                    'choices'   =>  array(
                        'm' =>  'Mężczyzna',
                        'k' =>  'Kobieta',
                    ),
                    'label' =>  'Płeć'
                )
            )
            ->add('stanowisko')
            ->add('zainteresowania')
            ->add('miejscowosc')
            ->add('kodPocztowy')
            ->add('ulica')
            ->add('korporacja',null,array('label'=>'Korporacja:'))
            ->add('telefonStacjonarny',null,array('label'=>'Tel. stacjonarny:'))
            ->add('komorka',null,array('label'=>'Tel. komórkowy:'))
//            ->add('telefonStacjonarnyPrefix')
            ->add('skype',null,array('label'=>'Skype:'))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'    => 'DFP\EtapIBundle\Entity\ProfilUzytkownika',
            'upload_form'   =>  false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_profiluzytkownika';
    }
}
