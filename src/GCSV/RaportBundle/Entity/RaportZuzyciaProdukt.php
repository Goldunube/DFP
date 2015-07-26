<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaportZuzyciaProdukt
 *
 * @ORM\Table(name="raporty_zuzyc_produkty")
 * @ORM\Entity(repositoryClass="GCSV\RaportBundle\Entity\RaportZuzyciaProduktRepository")
 */
class RaportZuzyciaProdukt
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="GCSV\RaportBundle\Entity\RaportZuzycia", inversedBy="raportZuzyciaProdukty")
     * @ORM\JoinColumn(name="raport_zuzycia_id",nullable=false)
     */
    private $raportZuzycia;

    /**
     * @ORM\ManyToOne(targetEntity="GCSV\MagazynBundle\Entity\Produkt", inversedBy="raportZuzyciaProdukty")
     * @ORM\JoinColumn(name="produkt_id", nullable=false)
     */
    private $produkt;

    /**
     * @var string
     *
     * @ORM\Column(name="ilosc_zuzyta", type="decimal", scale=3, nullable=true)
     */
    private $iloscZuzyta;

    /**
     * @var string
     *
     * @ORM\Column(name="ilosc_zostawiona", type="decimal", scale=3, nullable=true)
     */
    private $iloscZostawiona;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set iloscZuzyta
     *
     * @param string $iloscZuzyta
     * @return RaportZuzyciaProdukt
     */
    public function setIloscZuzyta($iloscZuzyta)
    {
        $this->iloscZuzyta = $iloscZuzyta;

        return $this;
    }

    /**
     * Get iloscZuzyta
     *
     * @return string 
     */
    public function getIloscZuzyta()
    {
        return $this->iloscZuzyta;
    }

    /**
     * Set iloscZostawiona
     *
     * @param string $iloscZostawiona
     * @return RaportZuzyciaProdukt
     */
    public function setIloscZostawiona($iloscZostawiona)
    {
        $this->iloscZostawiona = $iloscZostawiona;

        return $this;
    }

    /**
     * Get iloscZostawiona
     *
     * @return string 
     */
    public function getIloscZostawiona()
    {
        return $this->iloscZostawiona;
    }

    /**
     * @return mixed
     */
    public function getRaportZuzycia()
    {
        return $this->raportZuzycia;
    }

    /**
     * @param RaportZuzycia $raportZuzycia
     * @return $this
     */
    public function setRaportZuzycia(RaportZuzycia $raportZuzycia = null)
    {
        $this->raportZuzycia = $raportZuzycia;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProdukt()
    {
        return $this->produkt;
    }

    /**
     * @param mixed $produkt
     */
    public function setProdukt($produkt)
    {
        $this->produkt = $produkt;
    }
}
