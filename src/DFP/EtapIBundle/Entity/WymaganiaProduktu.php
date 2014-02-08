<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WymaganiaProduktu
 *
 * @ORM\Table(name="wymagania_produktow")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\WymaganiaProduktuRepository")
 */
class WymaganiaProduktu
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
     * @ORM\Column(name="nazwaParametru", type="string", length=150)
     */
    private $nazwaParametru;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", nullable=true)
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaWymaganiaProduktu", mappedBy="wymaganiaProduktu", cascade={"persist"})
     */
    private $filieWymaganiaProduktow;


    public function __construct()
    {
        $this->filieWymaganiaProduktow = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getNazwaParametru();
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
     * Set nazwaParametru
     *
     * @param string $nazwaParametru
     * @return WymaganiaProduktu
     */
    public function setNazwaParametru($nazwaParametru)
    {
        $this->nazwaParametru = $nazwaParametru;
    
        return $this;
    }

    /**
     * Get nazwaParametru
     *
     * @return string 
     */
    public function getNazwaParametru()
    {
        return $this->nazwaParametru;
    }

    /**
     * Set opis
     *
     * @param string $opis
     * @return WymaganiaProduktu
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
     * Add filieWymaganiaProduktow
     *
     * @param FiliaWymaganiaProduktu $filieWymaganiaProduktow
     * @return WymaganiaProduktu
     */
    public function addFilieWymaganiaProduktow(FiliaWymaganiaProduktu $filieWymaganiaProduktow)
    {
        $this->filieWymaganiaProduktow[] = $filieWymaganiaProduktow;
    
        return $this;
    }

    /**
     * Remove filieWymaganiaProduktow
     *
     * @param FiliaWymaganiaProduktu $filieWymaganiaProduktow
     */
    public function removeFilieWymaganiaProduktow(FiliaWymaganiaProduktu $filieWymaganiaProduktow)
    {
        $this->filieWymaganiaProduktow->removeElement($filieWymaganiaProduktow);
    }

    /**
     * Get filieWymaganiaProduktow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieWymaganiaProduktow()
    {
        return $this->filieWymaganiaProduktow;
    }
}