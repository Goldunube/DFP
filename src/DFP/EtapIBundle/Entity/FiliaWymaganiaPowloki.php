<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaWymaganiaPowloki
 *
 * @ORM\Table(name="filie_wymagania_powlok")
 * @ORM\Entity
 */
class FiliaWymaganiaPowloki
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
     * @ORM\Column(name="info", type="string", length=255, nullable=true)
     */
    private $info;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieWymaganiaPowlok")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", nullable=false)
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="WymaganiaPowloki", inversedBy="filieWymaganiaPowlok")
     * @ORM\JoinColumn(name="wymagania_powloki_id", referencedColumnName="id", nullable=false)
     */
    private $wymaganiaPowloki;


    /**
     * @return string
     */
    public function __toString()
    {
        /**
         * @var WymaganiaPowloki $wymaganiaPowloki
         */
        $wymaganiaPowloki = $this->wymaganiaPowloki;
        return (string) $wymaganiaPowloki->getNazwaParametru();
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
     * Set info
     *
     * @param string $info
     * @return FiliaWymaganiaPowloki
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaWymaganiaPowloki
     */
    public function setFilia(Filia $filia = null)
    {
        $this->filia = $filia;
    
        return $this;
    }

    /**
     * Get filia
     *
     * @return Filia
     */
    public function getFilia()
    {
        return $this->filia;
    }

    /**
     * Set wymaganiaPowloki
     *
     * @param WymaganiaPowloki $wymaganiaPowloki
     * @return FiliaWymaganiaPowloki
     */
    public function setWymaganiaPowloki(WymaganiaPowloki $wymaganiaPowloki = null)
    {
        $this->wymaganiaPowloki = $wymaganiaPowloki;
    
        return $this;
    }

    /**
     * Get wymaganiaPowloki
     *
     * @return WymaganiaPowloki
     */
    public function getWymaganiaPowloki()
    {
        return $this->wymaganiaPowloki;
    }
}