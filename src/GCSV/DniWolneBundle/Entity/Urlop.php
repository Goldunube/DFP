<?php

namespace GCSV\DniWolneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Urlop
 *
 * @ORM\Table(name="uzytkownicy_urlopy_informacje")
 * @ORM\Entity
 */
class Urlop
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
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(nullable=false)
     */
    private $osoba;

    /**
     * @var integer
     * @ORM\Column(name="ilosc_dni_urlopu")
     */
    private $dniUrlopu;

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
     * @return mixed
     */
    public function getOsoba()
    {
        return $this->osoba;
    }

    /**
     * @param mixed $osoba
     */
    public function setOsoba($osoba)
    {
        $this->osoba = $osoba;
    }

    /**
     * @return int
     */
    public function getDniUrlopu()
    {
        return $this->dniUrlopu;
    }

    /**
     * @param int $dniUrlopu
     */
    public function setDniUrlopu($dniUrlopu)
    {
        $this->dniUrlopu = $dniUrlopu;
    }
}
