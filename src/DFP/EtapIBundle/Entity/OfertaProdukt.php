<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaProdukt
 *
 * @ORM\Table(name="oferty_produkty")
 * @ORM\Entity
 */
class OfertaProdukt
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
     * @var array
     *
     * @ORM\Column(name="ceny", type="array")
     */
    private $ceny;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\OfertaHandlowa", inversedBy="ofertyProdukty")
     * @ORM\JoinColumn(name="oferta_id")
     */
    private $oferta;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\JoinColumn(name="produkt_id")
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
     * Set ceny
     *
     * @param array $ceny
     * @return OfertaProdukt
     */
    public function setCeny($ceny)
    {
        $this->ceny = $ceny;

        return $this;
    }

    /**
     * Get ceny
     *
     * @return array 
     */
    public function getCeny()
    {
        return $this->ceny;
    }

    /**
     * Set oferta
     *
     * @param OfertaHandlowa $oferta
     * @return OfertaProdukt
     */
    public function setOferta(OfertaHandlowa $oferta = null)
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * Get oferta
     *
     * @return OfertaHandlowa
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * Set produkt
     *
     * @param Produkt $produkt
     * @return OfertaProdukt
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
