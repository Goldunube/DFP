<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaUzytkownik
 *
 * @ORM\Table(name="filie_uzytkownicy")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaUzytkownikRepository")
 */
class FiliaUzytkownik
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
     * @var \DateTime
     *
     * @ORM\Column(name="poczatekPrzypisania", type="datetime")
     */
    private $poczatekPrzypisania;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="koniecPrzypisania", type="datetime", nullable=true)
     */
    private $koniecPrzypisania;

    /**
     * @var boolean
     *
     * @ORM\Column(name="perm", type="boolean")
     */
    private $perm = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="akcept", type="boolean")
     */
    private $akcept = true;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieUzytkownicy")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Uzytkownik", inversedBy="filieUzytkownicy")
     * @ORM\JoinColumn(name="uzytkownik_id", referencedColumnName="id", nullable=false)
     * @ORM\OrderBy({"imie"="ASC"})
     */
    private $uzytkownik;

    /**
     * @var boolean
     * @ORM\Column(name="blokada", type="boolean")
     */
    private $blokada = false;


    public function __toString()
    {
        return (string) $this->getUzytkownik();
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
     * Set poczatekPrzypisania
     *
     * @param \DateTime $poczatekPrzypisania
     * @return FiliaUzytkownik
     */
    public function setPoczatekPrzypisania($poczatekPrzypisania)
    {
        $this->poczatekPrzypisania = $poczatekPrzypisania;
    
        return $this;
    }

    /**
     * Get poczatekPrzypisania
     *
     * @return \DateTime 
     */
    public function getPoczatekPrzypisania()
    {
        return $this->poczatekPrzypisania;
    }

    /**
     * Set koniecPrzypisania
     *
     * @param \DateTime $koniecPrzypisania
     * @return FiliaUzytkownik
     */
    public function setKoniecPrzypisania($koniecPrzypisania)
    {
        $this->koniecPrzypisania = $koniecPrzypisania;
    
        return $this;
    }

    /**
     * Get koniecPrzypisania
     *
     * @return \DateTime 
     */
    public function getKoniecPrzypisania()
    {
        return $this->koniecPrzypisania;
    }

    /**
     * Set perm
     *
     * @param boolean $perm
     * @return FiliaUzytkownik
     */
    public function setPerm($perm)
    {
        $this->perm = $perm;
    
        return $this;
    }

    /**
     * Get perm
     *
     * @return boolean 
     */
    public function getPerm()
    {
        return $this->perm;
    }

    /**
     * Set akcept
     *
     * @param boolean $akcept
     * @return FiliaUzytkownik
     */
    public function setAkcept($akcept)
    {
        $this->akcept = $akcept;
    
        return $this;
    }

    /**
     * Get akcept
     *
     * @return boolean 
     */
    public function getAkcept()
    {
        return $this->akcept;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaUzytkownik
     */
    public function setFilia(Filia $filia = null)
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
     * Set uzytkownik
     *
     * @param Uzytkownik $uzytkownik
     * @return FiliaUzytkownik
     */
    public function setUzytkownik(Uzytkownik $uzytkownik = null)
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
     * @return boolean
     */
    public function getBlokada()
    {
        return $this->blokada;
    }

    /**
     * @param boolean $blokada
     */
    public function setBlokada($blokada)
    {
        $this->blokada = $blokada;
    }
}