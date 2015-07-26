<?php

namespace GCSV\MagazynBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GCSV\UserBundle\Entity\Uzytkownik;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * StanMagazynuWirtualny
 *
 * @ORM\Table(name="stany_magazynowe_wirtualne")
 * @ORM\Entity(repositoryClass="GCSV\MagazynBundle\Entity\StanMagazynuWirtualnyRepository")
 */
class StanMagazynuWirtualny
{
    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GCSV\UserBundle\Entity\Uzytkownik",inversedBy="stanyMagazynoweWirtualne")
     */
    private $uzytkownik;

    /**
     * @ORM\Id()
     * @ORM\ManyToOne(targetEntity="GCSV\MagazynBundle\Entity\Produkt",inversedBy="stanyMagazynoweWirtualne")
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
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="data_aktualizacji", type="datetime")
     */
    private $dataAktualizacji;


    /**
     * Set ilosc
     *
     * @param float $ilosc
     * @return StanMagazynuWirtualny
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
     * @return StanMagazynuWirtualny
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
     * Set uzytkownik
     *
     * @param Uzytkownik $uzytkownik
     * @return StanMagazynuWirtualny
     */
    public function setUzytkownik(Uzytkownik $uzytkownik = null)
    {
        $this->uzytkownik = $uzytkownik;

        return $this;
    }

    /**
     * Get magazyn
     *
     * @return Magazyn
     */
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }

    /**
     * Set produkt
     *
     * @param Produkt $produkt
     * @return StanMagazynuWirtualny
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
