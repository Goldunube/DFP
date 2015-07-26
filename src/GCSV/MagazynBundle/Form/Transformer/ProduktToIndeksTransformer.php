<?php

namespace GCSV\MagazynBundle\Form\Transformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class ProduktToIndeksTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    protected $objectManager;

    public function __construct(ObjectManager $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function transform($id)
    {
        if (null === $id) {
            return null;
        }

        $produkt = $this->objectManager->getRepository('GCSVMagazynBundle:Produkt')->find($id);

        return $produkt->getIndeks();
    }

    public function reverseTransform($indeks)
    {
        if (!$indeks) {
            return null;
        }

        $produkt = $this->objectManager->getRepository('GCSVMagazynBundle:Produkt')->findOneByIndeks($indeks);

        if (null === $produkt) {
            throw new TransformationFailedException('Obiekt klasy "Produkt" nie został odnaleziony.');
        }

        return $produkt;
    }
}

