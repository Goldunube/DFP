<?php

namespace GCSV\MagazynBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MagazynMAX
 *
 * @ORM\Table(name="stany_magazynowe_max")
 * @ORM\Entity(repositoryClass="GCSV\MagazynBundle\Entity\StanMagazynuMAXRepository")
 */
class StanMagazynuMAX
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GCSV\MagazynBundle\Entity\Magazyn",inversedBy="stanyMagazynoweMAX")
     */
    private $magazyn;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GCSV\MagazynBundle\Entity\Produkt",inversedBy="stanyMagazynoweMAX")
     */
    private $produkt;

    /**
     * @var float
     *
     * @ORM\Column(name="ilosc", type="float", scale=2, precision=12)
     */
    private $ilosc;

    /**
     * @var float
     *
     * @ORM\Column(name="wartosc", type="decimal", scale=2, precision=10)
     */
    private $wartosc;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_aktualizacji", type="datetime")
     */
    private $dataAktualizacji;


    /**
     * Set ilosc
     *
     * @param float $ilosc
     * @return StanMagazynuMAX
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return float 
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set wartosc
     *
     * @param float $wartosc
     * @return StanMagazynuMAX
     */
    public function setWartosc($wartosc)
    {
        $this->wartosc = $wartosc;

        return $this;
    }

    /**
     * Get wartosc
     *
     * @return float 
     */
    public function getWartosc()
    {
        return $this->wartosc;
    }

    /**
     * @return \DateTime
     */
    public function getDataAktualizacji()
    {
        return $this->dataAktualizacji;
    }

    /**
     * @param \DateTime $dataAktualizacji
     */
    public function setDataAktualizacji($dataAktualizacji)
    {
        $this->dataAktualizacji = $dataAktualizacji;
    }

    /**
     * Set magazyn
     *
     * @param Magazyn $magazyn
     * @return StanMagazynuMAX
     */
    public function setMagazyn(Magazyn $magazyn = null)
    {
        $this->magazyn = $magazyn;

        return $this;
    }

    /**
     * Get magazyn
     *
     * @return Magazyn
     */
    public function getMagazyn()
    {
        return $this->magazyn;
    }

    /**
     * Set produkt
     *
     * @param Produkt $produkt
     * @return StanMagazynuMAX
     */
    public function setProdukt(Produkt $produkt = null)
    {
        $this->produkt = $produkt;

        return $this;
    }

    /**
     * Get produkt
     *
     * @return Produkt
     */
    public function getProdukt()
    {
        return $this->produkt;
    }
}
