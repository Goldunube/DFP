<?php

namespace GCSV\MagazynBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GCSV\UserBundle\Entity\Uzytkownik;

/**
 * Magazyn
 *
 * @ORM\Table(name="magazyny")
 * @ORM\Entity
 */
class Magazyn
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
     * @ORM\OneToOne(targetEntity="GCSV\UserBundle\Entity\Uzytkownik",inversedBy="magazyn")
     * @ORM\JoinColumn(nullable=false)
     */
    private $uzytkownik;

    /**
     * @var string
     *
     * @ORM\Column(name="symbol", type="string", length=10)
     */
    private $symbol;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\MagazynBundle\Entity\StanMagazynuMAX",mappedBy="magazyn",cascade={"persist","remove"})
     */
    private $stanyMagazynoweMAX;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stanyMagazynoweMAX = new ArrayCollection();
        $this->stanyMagazynoweWirtualne = new ArrayCollection();
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
     * Set symbol
     *
     * @param string $symbol
     * @return Magazyn
     */
    public function setSymbol($symbol)
    {
        $this->symbol = $symbol;

        return $this;
    }

    /**
     * Get symbol
     *
     * @return string 
     */
    public function getSymbol()
    {
        return $this->symbol;
    }

    /**
     * Set uzytkownik
     *
     * @param Uzytkownik $uzytkownik
     * @return Magazyn
     */
    public function setOsoba(Uzytkownik $uzytkownik = null)
    {
        $this->uzytkownik = $uzytkownik;

        return $this;
    }

    /**
     * Get uzytkownik
     *
     * @return Uzytkownik
     */
    public function getOsoba()
    {
        return $this->uzytkownik;
    }

    /**
     * Set uzytkownik
     *
     * @param Uzytkownik $uzytkownik
     * @return Magazyn
     */
    public function setUzytkownik(Uzytkownik $uzytkownik)
    {
        $this->uzytkownik = $uzytkownik;

        return $this;
    }

    /**
     * Get uzytkownik
     *
     * @return Uzytkownik
     */
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }

    /**
     * Add stanyMagazynoweMAX
     *
     * @param StanMagazynuMAX $stanyMagazynoweMAX
     * @return Magazyn
     */
    public function addStanyMagazynoweMAX(StanMagazynuMAX $stanyMagazynoweMAX)
    {
        if(!$this->stanyMagazynoweMAX->contains($stanyMagazynoweMAX))
        {
            $this->stanyMagazynoweMAX->add($stanyMagazynoweMAX);
        }
    }

    /**
     * Remove stanyMagazynoweMAX
     *
     * @param StanMagazynuMAX $stanyMagazynoweMAX
     */
    public function removeStanyMagazynoweMAX(StanMagazynuMAX $stanyMagazynoweMAX)
    {
        $this->stanyMagazynoweMAX->removeElement($stanyMagazynoweMAX);
    }

    /**
     * Get stanyMagazynoweMAX
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStanyMagazynoweMAX()
    {
        return $this->stanyMagazynoweMAX;
    }
}
