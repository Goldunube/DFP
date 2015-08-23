<?php

namespace GCSV\TechnicalBundle\Form\DataTransformer;

use DFP\EtapIBundle\Entity\Klient;
use Doctrine\Common\Persistence\ObjectManager;
use DFP\EtapIBundle\Entity\Filia;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FirmaOddzialTransformer implements DataTransformerInterface
{
    private $om;
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    /**
     * Transforms an object (oddzial) to a string (nazwa).
     *
     * @param mixed $id
     * @internal param \GCSV\CustomerBundle\Entity\Oddzial|null $oddzial
     * @return string
     */
    public function transform($id)
    {
        if (null === $id)
        {
            return '';
        }

        $filia = $this->om->getRepository('DFPEtapIBundle:Filia')->find($id);
        /**
         * @var Klient $firma
         */
        $klient = $filia->getKlient();

        return $klient->getNazwaSkrocona();
    }
    /**
     * Transforms a string (id) to an object (object).
     *
     * @param string $nazwa
     * @return Object|null
     * @throws TransformationFailedException if object (object) is not found.
     */
    public function reverseTransform($nazwa)
    {
        if (empty($nazwa)) {
            return null;
        }

        $rozdzielenie = preg_split("/(\\([^().]*\\))$/",$nazwa,null,PREG_SPLIT_DELIM_CAPTURE);
        $nazwaSkroconaFirmy = trim($rozdzielenie[0]);
        if(isset($rozdzielenie[1]))
        {
            $nazwaOddzialu = trim($rozdzielenie[1]);
            $nazwaOddzialu = str_replace(array('(',')'),'',$nazwaOddzialu);
        }
        $klient = $this->om->getRepository('DFPEtapIBundle:Klient')->findOneBy(array('nazwaSkrocona'=>$nazwaSkroconaFirmy));

        if (null === $klient) {
            throw new TransformationFailedException(sprintf('Obiekt klasy "Klient" nie został odnaleziony.'));
        }

        $filia = $this->om->getRepository('DFPEtapIBundle:Filia')->findOneBy(array('klient'=>$klient->getId()));
        if (null === $filia) {
            throw new TransformationFailedException(sprintf('Obiekt klasy "Filia" o podanym identyfikatorze nie został odnaleziony'));
        }
        return $filia;
    }
} 