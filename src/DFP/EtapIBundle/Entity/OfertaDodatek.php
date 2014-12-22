<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaDodatek
 *
 * @ORM\Table(name="oferty_dodatki")
 * @ORM\Entity
 */
class OfertaDodatek
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
     * @var string
     *
     * @ORM\Column(name="cena", type="decimal")
     */
    private $cena;

    /**
     * @var string
     *
     * @ORM\Column(name="opakowanie", type="string", length=255)
     */
    private $opakowanie;

    /**
     * @var string
     *
     * @ORM\Column(name="jednostka", type="string", length=255)
     */
    private $jednostka;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\OfertaHandlowa", inversedBy="ofertyDodatki")
     * @ORM\JoinColumn(name="oferta_id", nullable=false)
     */
    private $oferta;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\JoinColumn(name="produkt_id", nullable=false)
     */
    private $produkt;


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
     * Set cena
     *
     * @param string $cena
     * @return OfertaDodatek
     */
    public function setCena($cena)
    {
        $this->cena = $cena;

        return $this;
    }

    /**
     * Get cena
     *
     * @return string 
     */
    public function getCena()
    {
        return $this->cena;
    }

    /**
     * Set opakowanie
     *
     * @param string $opakowanie
     * @return OfertaDodatek
     */
    public function setOpakowanie($opakowanie)
    {
        $this->opakowanie = $opakowanie;

        return $this;
    }

    /**
     * Get opakowanie
     *
     * @return string 
     */
    public function getOpakowanie()
    {
        return $this->opakowanie;
    }

    /**
     * Set jednostka
     *
     * @param string $jednostka
     * @return OfertaDodatek
     */
    public function setJednostka($jednostka)
    {
        $this->jednostka = $jednostka;

        return $this;
    }

    /**
     * Get jednostka
     *
     * @return string 
     */
    public function getJednostka()
    {
        return $this->jednostka;
    }

    /**
     * @return mixed
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * @param mixed $oferta
     */
    public function setOferta($oferta)
    {
        $this->oferta = $oferta;
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
