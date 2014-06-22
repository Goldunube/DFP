<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WzornikKolorow
 *
 * @ORM\Table(name="wzorniki_kolorow")
 * @ORM\Entity
 */
class WzornikKolorow
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
     * @ORM\Column(name="nazwa", type="string", length=25)
     */
    private $nazwa;

    /**
     * @ORM\OneToMany(targetEntity="Kolor", mappedBy="wzornikKoloru", cascade={"all"})
     */
    protected $kolory;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->kolory = new ArrayCollection();
    }

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
     * @return WzornikKolorow
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
     * Add kolory
     *
     * @param Kolor $kolory
     * @return WzornikKolorow
     */
    public function addKolory(Kolor $kolory)
    {
        $this->kolory[] = $kolory;

        return $this;
    }

    /**
     * Remove kolory
     *
     * @param Kolor $kolory
     */
    public function removeKolory(Kolor $kolory)
    {
        $this->kolory->removeElement($kolory);
    }

    /**
     * Get kolory
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKolory()
    {
        return $this->kolory;
    }
}
