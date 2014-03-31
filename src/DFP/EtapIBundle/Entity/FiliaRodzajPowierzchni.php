<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaRodzajPowierzchni
 *
 * @ORM\Table(name="filie_rodzaje_powierzchni")
 * @ORM\Entity
 */
class FiliaRodzajPowierzchni
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
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieRodzajePowierzchni")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", nullable=false)
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="RodzajPowierzchni", inversedBy="filieRodzajePowierzchni")
     * @ORM\JoinColumn(name="rodzaj_powierzchni_id", referencedColumnName="id", nullable=false)
     */
    private $rodzajPowierzchni;


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
     * @return FiliaRodzajPowierzchni
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
     * @return FiliaRodzajPowierzchni
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
     * Set rodzajPowierzchni
     *
     * @param RodzajPowierzchni $rodzajPowierzchni
     * @return FiliaRodzajPowierzchni
     */
    public function setRodzajPowierzchni(RodzajPowierzchni $rodzajPowierzchni = null)
    {
        $this->rodzajPowierzchni = $rodzajPowierzchni;
    
        return $this;
    }

    /**
     * Get rodzajPowierzchni
     *
     * @return RodzajPowierzchni
     */
    public function getRodzajPowierzchni()
    {
        return $this->rodzajPowierzchni;
    }
}