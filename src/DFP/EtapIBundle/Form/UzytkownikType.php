<?php

namespace DFP\EtapIBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UzytkownikType extends AbstractType
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
            ->add('email', 'email', array(
                    'label' => 'form.email',
                    'translation_domain' => 'FOSUserBundle',
                    'attr'  =>  array('autocomplete'=>'off'),
                )
            )
            ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                    'first_options' => array('label' => 'form.password'),
                    'second_options' => array('label' => 'form.password_confirmation'),
                    'invalid_message' => 'fos_user.password.mismatch',
                ))
//            ->add('roles')
            ->add('profilUzytkownika', new ProfilType(),array(
                    'label'         =>  false,
                    'upload_form'   =>  false,
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
            'data_class' => 'DFP\EtapIBundle\Entity\Uzytkownik'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'dfp_etapibundle_uzytkownik';
    }
}
