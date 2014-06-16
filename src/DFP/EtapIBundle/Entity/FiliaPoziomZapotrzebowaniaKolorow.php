<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaPoziomZapotrzebowaniaKolorow
 *
 * @ORM\Table(name="filie_poziomy_zap_kolorow")
 * @ORM\Entity
 */
class FiliaPoziomZapotrzebowaniaKolorow
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
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filiePoziomyZapotrzebowaniaKolorow")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", nullable=false)
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Kolor", inversedBy="filiePoziomyZapotrzebowaniaKolorow")
     * @ORM\JoinColumn(name="kolor_id", referencedColumnName="id", nullable=false)
     */
    private $kolor;

    /**
     * @var integer
     *
     * @ORM\Column(name="poziomZuzycia", type="integer")
     */
    private $poziomZuzycia;


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
     * Set poziomZuzycia
     *
     * @param integer $poziomZuzycia
     * @return FiliaPoziomZapotrzebowaniaKolorow
     */
    public function setPoziomZuzycia($poziomZuzycia)
    {
        $this->poziomZuzycia = $poziomZuzycia;

        return $this;
    }

    /**
     * Get poziomZuzycia
     *
     * @return integer 
     */
    public function getPoziomZuzycia()
    {
        return $this->poziomZuzycia;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaPoziomZapotrzebowaniaKolorow
     */
    public function setFilia(Filia $filia)
    {
        $this->filia = $filia;

        return $this;
    }

    /**
     * Get filia
     *
     * @return Filia
     */
    public function getFilia()
    {
        return $this->filia;
    }

    /**
     * Set kolor
     *
     * @param Kolor $kolor
     * @return FiliaPoziomZapotrzebowaniaKolorow
     */
    public function setKolor(Kolor $kolor)
    {
        $this->kolor = $kolor;

        return $this;
    }

    /**
     * Get kolor
     *
     * @return Kolor
     */
    public function getKolor()
    {
        return $this->kolor;
    }
}
