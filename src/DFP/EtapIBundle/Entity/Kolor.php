<?php

namespace DFP\EtapIBundle\Entity;

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
}
