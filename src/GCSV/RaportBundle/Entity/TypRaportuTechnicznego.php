<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TypRaportuTechnicznego
 *
 * @ORM\Table(name="typ_raportu_technicznego")
 * @ORM\Entity
 */
class TypRaportuTechnicznego
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
     * @ORM\Column(name="nazwa", type="string", length=255)
     */
    private $nazwa;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktywny", type="boolean")
     */
    private $aktywny;


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
     * @return TypRaportuTechnicznego
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
     * Set aktywny
     *
     * @param boolean $aktywny
     * @return TypRaportuTechnicznego
     */
    public function setAktywny($aktywny)
    {
        $this->aktywny = $aktywny;

        return $this;
    }

    /**
     * Get aktywny
     *
     * @return boolean 
     */
    public function getAktywny()
    {
        return $this->aktywny;
    }
}
