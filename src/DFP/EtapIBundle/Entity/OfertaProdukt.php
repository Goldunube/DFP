<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\OneToMany(targetEntity="DFP\EtapIBundle\Entity\OfertaCena",mappedBy="ofertaProdukt",cascade={"ALL"}, orphanRemoval=true)
     */
    private $ceny;

    /**
     * @var integer
     * @ORM\Column(name="opakowanie_wartosc", type="integer", nullable=false)
     */
    private $opakowanieWartosc;

    /**
     * @var string
     * @ORM\Column(name="opakowanie_jednostka", type="string", length=15, nullable=false)
     */
    private $opakowanieJednostka;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\OfertaHandlowa", inversedBy="ofertyProdukty")
     * @ORM\JoinColumn(name="oferta_id", nullable=false)
     */
    private $oferta;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\JoinColumn(name="produkt_id", nullable=false)
     */
    private $produkt;

    /**
     * @var string
     * @ORM\Column(name="informacje", type="text", nullable=true)
     */
    private $informacjeDodatkowe;


    public function __construct()
    {
        $this->ceny = new ArrayCollection();
    }

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
     * Add ceny
     *
     * @param OfertaCena $cena
     * @return OfertaProdukt
     */
    public function addCeny(OfertaCena $cena)
    {
        $cena->setOfertaProdukt($this);
        $this->ceny->add($cena);

        return $this;
    }

    /**
     * Remove ceny
     *
     * @param OfertaCena $cena
     */
    public function removeCeny(OfertaCena $cena)
    {
        $this->ceny->removeElement($cena);
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

    /**
     * @return int
     */
    public function getOpakowanieWartosc()
    {
        return $this->opakowanieWartosc;
    }

    /**
     * @param int $opakowanieWartosc
     */
    public function setOpakowanieWartosc($opakowanieWartosc)
    {
        $this->opakowanieWartosc = $opakowanieWartosc;
    }

    /**
     * @return string
     */
    public function getOpakowanieJednostka()
    {
        return $this->opakowanieJednostka;
    }

    /**
     * @param string $opakowanieJednostka
     */
    public function setOpakowanieJednostka($opakowanieJednostka)
    {
        $this->opakowanieJednostka = $opakowanieJednostka;
    }

    /**
     * @return string
     */
    public function getInformacjeDodatkowe()
    {
        return $this->informacjeDodatkowe;
    }

    /**
     * @param string $informacjeDodatkowe
     */
    public function setInformacjeDodatkowe($informacjeDodatkowe)
    {
        $this->informacjeDodatkowe = $informacjeDodatkowe;
    }
}
