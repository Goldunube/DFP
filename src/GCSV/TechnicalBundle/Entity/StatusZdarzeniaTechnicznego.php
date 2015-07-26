<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StatusZdarzeniaTechnicznego
 *
 * @ORM\Table(name="statusy_zdarzen_technicznych")
 * @ORM\Entity
 */
class StatusZdarzeniaTechnicznego
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
     * @ORM\Column(name="wartosc", type="integer", unique=true, nullable=false)
     */
    private $wartosc;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=25)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text")
     */
    private $opis;


    public function __toString()
    {
        return (string) $this->nazwa;
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
     * @return StatusZdarzeniaTechnicznego
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
     * Set opis
     *
     * @param string $opis
     * @return StatusZdarzeniaTechnicznego
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;

        return $this;
    }

    /**
     * Get opis
     *
     * @return string 
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * @return int
     */
    public function getWartosc()
    {
        return $this->wartosc;
    }

    /**
     * @param int $wartosc
     */
    public function setWartosc($wartosc)
    {
        $this->wartosc = $wartosc;
    }
}
