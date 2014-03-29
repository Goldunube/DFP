<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * RodzajPowierzchni
 *
 * @ORM\Table(name="rodzaje_powierzchni")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\RodzajPowierzchniRepository")
 */
class RodzajPowierzchni
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
     * @ORM\Column(name="nazwa", type="string", length=150)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", nullable=true)
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaRodzajPowierzchni", mappedBy="rodzajPowierzchni", cascade={"persist"})
     */
    private $filieRodzajePowierzchni;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieRodzajePowierzchni = new ArrayCollection();
    }

    /**
     * To String
     * @return string
     *
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
     * @return RodzajPowierzchni
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
     * @return RodzajPowierzchni
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
     * Add filieRodzajePowierzchni
     *
     * @param FiliaRodzajPowierzchni $filieRodzajePowierzchni
     * @return RodzajPowierzchni
     */
    public function addFilieRodzajePowierzchni(FiliaRodzajPowierzchni $filieRodzajePowierzchni)
    {
        $this->filieRodzajePowierzchni[] = $filieRodzajePowierzchni;
    
        return $this;
    }

    /**
     * Remove filieRodzajePowierzchni
     *
     * @param FiliaRodzajPowierzchni $filieRodzajePowierzchni
     */
    public function removeFilieRodzajePowierzchni(FiliaRodzajPowierzchni $filieRodzajePowierzchni)
    {
        $this->filieRodzajePowierzchni->removeElement($filieRodzajePowierzchni);
    }

    /**
     * Get filieRodzajePowierzchni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieRodzajePowierzchni()
    {
        return $this->filieRodzajePowierzchni;
    }
}