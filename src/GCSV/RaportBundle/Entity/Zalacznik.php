<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Zalacznik
 *
 * @ORM\Table(name="zdarzenia_techniczne_zalaczniki")
 * @ORM\Entity
 */
class Zalacznik
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
     * @ORM\Column(name="plik", type="string", length=255)
     */
    private $sciezka;

    /**
     * @var string
     *
     * @ORM\Column(name="zalacznikFile", type="string", length=255)
     */
    private $zalacznik;

    /**
     * @var string
     *
     * @ORM\Column(name="zalacznikTemp", type="string", length=255)
     */
    private $zalacznikTemp;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="aktualizacja", type="datetime")
     */
    private $aktualizacja;


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
     * Set plik
     *
     * @param string $sciezka
     * @return Zalacznik
     */
    public function setSciezka($sciezka)
    {
        $this->sciezka = $sciezka;

        return $this;
    }

    /**
     * Get sciezka
     *
     * @return string 
     */
    public function getSciezka()
    {
        return $this->sciezka;
    }

    /**
     * Set zalacznik
     *
     * @param string $zalacznik
     * @return Zalacznik
     */
    public function setZalacznik($zalacznik)
    {
        $this->zalacznik = $zalacznik;

        return $this;
    }

    /**
     * Get zalacznik
     *
     * @return string 
     */
    public function getZalacznik()
    {
        return $this->zalacznik;
    }

    /**
     * Set zalacznikTemp
     *
     * @param string $zalacznikTemp
     * @return Zalacznik
     */
    public function setZalacznikTemp($zalacznikTemp)
    {
        $this->zalacznikTemp = $zalacznikTemp;

        return $this;
    }

    /**
     * Get zalacznikTemp
     *
     * @return string 
     */
    public function getZalacznikTemp()
    {
        return $this->zalacznikTemp;
    }

    /**
     * Set aktualizacja
     *
     * @param \DateTime $aktualizacja
     * @return Zalacznik
     */
    public function setAktualizacja($aktualizacja)
    {
        $this->aktualizacja = $aktualizacja;

        return $this;
    }

    /**
     * Get aktualizacja
     *
     * @return \DateTime 
     */
    public function getAktualizacja()
    {
        return $this->aktualizacja;
    }
}
