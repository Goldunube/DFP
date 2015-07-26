<?php

namespace GCSV\TechnicalBundle\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;

class StringToZdarzenieTransformer implements DataTransformerInterface
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

    /**
     * Transforms an object (Zdarzenie Techniczne) to a string (number).
     *
     * @param  ZdarzenieTechniczne|null $zdarzenieTechniczne
     * @return string
     */
    public function transform($zdarzenieTechniczne)
    {
        if (null === $zdarzenieTechniczne) {
            return "";
        }

        return $zdarzenieTechniczne->getId();
    }

    /**
     * Transforms a string (number) to an object (ZdarzenieTechniczne).
     *
     * @param  string $id
     *
     * @return ZdarzenieTechniczne|null
     *
     * @throws TransformationFailedException if object (ZdarzenieTechniczne) is not found.
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $zdarzenieTechniczne = $this->om
            ->getRepository('GCSVTechnicalBundle:ZdarzenieTechniczne')
            ->find($id)
        ;

        if (null === $zdarzenieTechniczne) {
            throw new TransformationFailedException(sprintf(
                'Zdarzenie Techniczne o numerze identyfikacyjnym "%s" nie istnieje!',
                $id
            ));
        }

        return $zdarzenieTechniczne;
    }
} 