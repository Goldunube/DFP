<?php

namespace DFP\EtapIBundle\Entity;

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
     * @ORM\Column(name="opis", type="text")
     */
    private $opis;


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
}
