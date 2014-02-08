<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * WymaganiaPowloki
 *
 * @ORM\Table(name="wymagania_powlok")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\WymaganiaPowlokiRepository")
 */
class WymaganiaPowloki
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
     * @ORM\Column(name="opis", type="text", nullable=true )
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaWymaganiaPowloki", mappedBy="wymaganiaPowloki", cascade={"persist"})
     */
    private $filieWymaganiaPowlok;


    public function __construct()
    {
        $this->filieWymaganiaPowlok = new ArrayCollection();
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
     * @return WymaganiaPowloki
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
     * @return WymaganiaPowloki
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
     * Add filieWymaganiaPowlok
     *
     * @param FiliaWymaganiaPowloki $filieWymaganiaPowlok
     * @return WymaganiaPowloki
     */
    public function addFilieWymaganiaPowlok(FiliaWymaganiaPowloki $filieWymaganiaPowlok)
    {
        $this->filieWymaganiaPowlok[] = $filieWymaganiaPowlok;
    
        return $this;
    }

    /**
     * Remove filieWymaganiaPowlok
     *
     * @param FiliaWymaganiaPowloki $filieWymaganiaPowlok
     */
    public function removeFilieWymaganiaPowlok(FiliaWymaganiaPowloki $filieWymaganiaPowlok)
    {
        $this->filieWymaganiaPowlok->removeElement($filieWymaganiaPowlok);
    }

    /**
     * Get filieWymaganiaPowlok
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieWymaganiaPowlok()
    {
        return $this->filieWymaganiaPowlok;
    }
}