<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RodzajZdarzeniaTechnicznego
 *
 * @ORM\Table(name="rodzaje_zdarzen_technicznych")
 * @ORM\Entity
 */
class RodzajZdarzeniaTechnicznego
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
     * @ORM\Column(name="nazwa", type="string", length=60, nullable=false)
     */
    private $nazwa;

    /**
     * @ORM\Column(name="opis", type="text", nullable=true)
     */
    private $opis;

    /**
     * @ORM\OneToMany(targetEntity="ZdarzenieTechniczne", mappedBy="rodzajZdarzeniaTechnicznego")
     */
    private $zdarzeniaTechniczne;

    /**
     * Ustawienie parametru na wartość 'true' powoduje wyświetlenie rodzaju wizyty w formularzu zgłoszeniowym dla wszystkich użytkowników
     *
     * @var bool
     * @ORM\Column(name="show_others",type="boolean",nullable=true)
     */
    private $showOthers = false;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->zdarzeniaTechniczne = new ArrayCollection();
        $this->rodzajePytan = new ArrayCollection();
    }

    /**
     * To String
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
     * @return RodzajZdarzeniaTechnicznego
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
     * @return mixed
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * @param mixed $opis
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;
    }

    /**
     * Add zdarzeniaTechniczne
     *
     * @param ZdarzenieTechniczne $zdarzeniaTechniczne
     * @return RodzajZdarzeniaTechnicznego
     */
    public function addZdarzeniaTechniczne(ZdarzenieTechniczne $zdarzeniaTechniczne)
    {
        $this->zdarzeniaTechniczne[] = $zdarzeniaTechniczne;

        return $this;
    }

    /**
     * Remove zdarzeniaTechniczne
     *
     * @param ZdarzenieTechniczne $zdarzeniaTechniczne
     */
    public function removeZdarzeniaTechniczne(ZdarzenieTechniczne $zdarzeniaTechniczne)
    {
        $this->zdarzeniaTechniczne->removeElement($zdarzeniaTechniczne);
    }

    /**
     * Get zdarzeniaTechniczne
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZdarzeniaTechniczne()
    {
        return $this->zdarzeniaTechniczne;
    }

    /**
     * Get rodzajePytan
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRodzajePytan()
    {
        return $this->rodzajePytan;
    }

    /**
     * @param boolean $showOthers
     */
    public function setShowOthers($showOthers)
    {
        $this->showOthers = $showOthers;
    }

    /**
     * @return boolean
     */
    public function getShowOthers()
    {
        return $this->showOthers;
    }
}
