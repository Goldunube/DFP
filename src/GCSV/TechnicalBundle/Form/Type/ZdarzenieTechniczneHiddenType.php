<?php

namespace GCSV\TechnicalBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use GCSV\TechnicalBundle\Form\DataTransformer\StringToZdarzenieTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ZdarzenieTechniczneHiddenType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $om;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new StringToZdarzenieTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'invalid_message' => 'Wskazane Zdarzenie Techniczne nie istnieje.',
            ));
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'zdarzenie_techniczne_hidden';
    }
} 