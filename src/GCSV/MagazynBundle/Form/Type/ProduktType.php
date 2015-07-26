<?php

namespace GCSV\MagazynBundle\Form\Type;


use Doctrine\Common\Persistence\ObjectManager;
use GCSV\MagazynBundle\Form\Transformer\ProduktToIndeksTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProduktType extends AbstractType
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'label'         =>  'Produkt',
                'class'         =>  'typeahead'
            )
        );
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $transformer = new ProduktToIndeksTransformer($this->objectManager);
        $builder->addModelTransformer($transformer);
    }

    public function getParent()
    {
        return 'text';
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'produkt_typeahead';
    }
}