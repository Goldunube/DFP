<?php

namespace GCSV\TechnicalBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use GCSV\TechnicalBundle\Form\DataTransformer\FirmaOddzialTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FirmaOddzialAutocompleteType extends AbstractType
{
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
        $transformer = new FirmaOddzialTransformer($this->om);
        $builder->addModelTransformer($transformer);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'invalid_message' => 'Wybrany element nie istnieje!',
            )
        );
    }

    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'gcsv_firma_oddzial_autocomplete';
    }
} 