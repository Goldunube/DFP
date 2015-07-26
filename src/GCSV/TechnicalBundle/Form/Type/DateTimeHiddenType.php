<?php

namespace GCSV\TechnicalBundle\Form\Type;

use GCSV\TechnicalBundle\Form\DataTransformer\DateTimeToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DateTimeHiddenType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new DateTimeToStringTransformer();
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        parent::setDefaultOptions($resolver);
        $resolver->setDefaults(array());
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'datetime_hidden';
    }
} 