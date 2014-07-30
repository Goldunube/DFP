<?php

namespace GCSV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class EdycjaProfiluUzytkownikaType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imie',null,array('label'=>'Imię:'))
            ->add('nazwisko',null,array('label'=>'Nazwisko:'))
//            ->add('username', null, array('label' => 'form.username', 'translation_domain' => 'FOSUserBundle'))
            ->add('profil', new ProfilType(),array(
                    'label' =>  false,
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
                'data_class'            =>  'GCSV\UserBundle\Entity\Uzytkownik',
//                'validation_groups'     =>  array('edycja_profilu')
            ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'gcsv_userbundle_uzytkownik_profil';
    }
}
