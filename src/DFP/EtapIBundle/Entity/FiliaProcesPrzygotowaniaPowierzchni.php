<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaProcesPrzygotowaniaPowierzchni
 *
 * @ORM\Table(name="filie_procesy_przogotowania_powierzchni")
 * @ORM\Entity
 */
class FiliaProcesPrzygotowaniaPowierzchni
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
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieProcesyPrzygotowaniaPowierzchni")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id")
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ProcesPrzygotowaniaPowierzchni", inversedBy="filieProcesyPrzygotowaniaPowierzchni")
     * @ORM\JoinColumn(name="proces_id", referencedColumnName="id")
     */
    private $procesPrzygotowaniaPowierzchni;


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
     * @return FiliaProcesPrzygotowaniaPowierzchni
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
     * @return FiliaProcesPrzygotowaniaPowierzchni
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
     * Set procesPrzygotowaniaPowierzchni
     *
     * @param ProcesPrzygotowaniaPowierzchni $procesPrzygotowaniaPowierzchni
     * @return FiliaProcesPrzygotowaniaPowierzchni
     */
    public function setProcesPrzygotowaniaPowierzchni(ProcesPrzygotowaniaPowierzchni $procesPrzygotowaniaPowierzchni = null)
    {
        $this->procesPrzygotowaniaPowierzchni = $procesPrzygotowaniaPowierzchni;
    
        return $this;
    }

    /**
     * Get procesPrzygotowaniaPowierzchni
     *
     * @return ProcesPrzygotowaniaPowierzchni
     */
    public function getProcesPrzygotowaniaPowierzchni()
    {
        return $this->procesPrzygotowaniaPowierzchni;
    }
}