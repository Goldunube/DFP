<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RaportTechnicznyExtraField
 */
//      * @ORM\Table(name="rt_extra_fields")
//      * @ORM\Entity(repositoryClass="GCSV\RaportBundle\Entity\RaportTechnicznyExtraFieldRepository")
class RaportTechnicznyExtraField
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
     * @ORM\Column(name="nazwa", type="string", length=100)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="typ", type="string", length=25)
     */
    private $typ;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wymagane", type="boolean")
     */
    private $wymagane;


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
     *
     * @return RaportTechnicznyExtraField
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
     * Set typ
     *
     * @param string $typ
     *
     * @return RaportTechnicznyExtraField
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Get typ
     *
     * @return string
     */
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * Set wymagane
     *
     * @param boolean $wymagane
     *
     * @return RaportTechnicznyExtraField
     */
    public function setWymagane($wymagane)
    {
        $this->wymagane = $wymagane;

        return $this;
    }

    /**
     * Get wymagane
     *
     * @return boolean
     */
    public function getWymagane()
    {
        return $this->wymagane;
    }
}

