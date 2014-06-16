<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Kolor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Kolor
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
     * @ORM\Column(name="nazwa", type="string", length=45)
     */
    private $nazwa;

    /**
     * @ORM\ManyToOne(targetEntity="WzornikKolorow", inversedBy="kolory")
     *
     * @ORM\JoinColumn(name="wzornik_koloru_id", referencedColumnName="id", nullable=false)
     */
    protected $wzornikKoloru;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaPoziomZapotrzebowaniaKolorow", mappedBy="kolor", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filiePoziomyZapotrzebowaniaKolorow;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filiePoziomyZapotrzebowaniaKolorow = new ArrayCollection();
    }

    /**
     * to String
     */
    public function __toString()
    {
        return (string) $this->getNazwa();
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
     * Set nazwa
     *
     * @param string $nazwa
     * @return Kolor
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set wzornikKoloru
     *
     * @param WzornikKolorow $wzornikKoloru
     * @return Kolor
     */
    public function setWzornikKoloru(WzornikKolorow $wzornikKoloru)
    {
        $this->wzornikKoloru = $wzornikKoloru;

        return $this;
    }

    /**
     * Get wzornikKoloru
     *
     * @return WzornikKolorow
     */
    public function getWzornikKoloru()
    {
        return $this->wzornikKoloru;
    }

    /**
     * Add filiePoziomyZapotrzebowaniaKolorow
     *
     * @param FiliaPoziomZapotrzebowaniaKolorow $filiePoziomyZapotrzebowaniaKolorow
     * @return Kolor
     */
    public function addFiliePoziomyZapotrzebowaniaKolorow(
        FiliaPoziomZapotrzebowaniaKolorow $filiePoziomyZapotrzebowaniaKolorow)
    {
        $this->filiePoziomyZapotrzebowaniaKolorow[] = $filiePoziomyZapotrzebowaniaKolorow;

        return $this;
    }

    /**
     * Remove filiePoziomyZapotrzebowaniaKolorow
     *
     * @param FiliaPoziomZapotrzebowaniaKolorow $filiePoziomyZapotrzebowaniaKolorow
     */
    public function removeFiliePoziomyZapotrzebowaniaKolorow(
        FiliaPoziomZapotrzebowaniaKolorow $filiePoziomyZapotrzebowaniaKolorow)
    {
        $this->filiePoziomyZapotrzebowaniaKolorow->removeElement($filiePoziomyZapotrzebowaniaKolorow);
    }

    /**
     * Get filiePoziomyZapotrzebowaniaKolorow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFiliePoziomyZapotrzebowaniaKolorow()
    {
        return $this->filiePoziomyZapotrzebowaniaKolorow;
    }
}
