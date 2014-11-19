<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class OfertaCena
 * @package DFP\EtapIBundle\Entity
 *
 * @ORM\Table(name="oferty_ceny")
 * @ORM\Entity
 */
class OfertaCena
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
     * @ORM\Column(name="kolor",type="string",length=25,nullable=true)
     */
    private $kolor = '';

    /**
     * @var string
     * @ORM\Column(name="wartosc",type="string",nullable=false)
     */
    private $wartosc = 0;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\OfertaProdukt",inversedBy="ceny")
     * @ORM\JoinColumn(name="oferta_produkt")
     */
    private $ofertaProdukt;

    /**
     * @return mixed
     */
    public function getKolor()
    {
        return $this->kolor;
    }

    /**
     * @param mixed $kolor
     */
    public function setKolor($kolor)
    {
        $this->kolor = $kolor;
    }

    /**
     * @return mixed
     */
    public function getWartosc()
    {
        return $this->wartosc;
    }

    /**
     * @param mixed $wartosc
     */
    public function setWartosc($wartosc)
    {
        $this->wartosc = $wartosc;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getOfertaProdukt()
    {
        return $this->ofertaProdukt;
    }

    /**
     * @param mixed $ofertaProdukt
     */
    public function setOfertaProdukt($ofertaProdukt)
    {
        $this->ofertaProdukt = $ofertaProdukt;
    }
} 