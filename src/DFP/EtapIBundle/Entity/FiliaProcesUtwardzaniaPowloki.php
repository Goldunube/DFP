<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaProcesUtwardzaniaPowloki
 *
 * @ORM\Table(name="filie_procesy_utwardzania_powloki")
 * @ORM\Entity
 */
class FiliaProcesUtwardzaniaPowloki
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
     * @var integer
     *
     * @ORM\Column(name="tempMin", type="integer", nullable=true)
     */
    private $tempMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="tempMax", type="integer", nullable=true)
     */
    private $tempMax;

    /**
     * @var string
     *
     * @ORM\Column(name="czasSchniecia", type="string", length=5, nullable=true)
     */
    private $czasSchniecia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieProcesyUtwardzaniaPowlok")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id")
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ProcesUtwardzaniaPowloki", inversedBy="filieProcesyUtwardzaniaPowlok")
     * @ORM\JoinColumn(name="proces_utwardzania_id", referencedColumnName="id")
     */
    private $procesUtwardzaniaPowloki;


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
     * Set czasSchniecia
     *
     * @param string $czasSchniecia
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setCzasSchniecia($czasSchniecia)
    {
        $this->czasSchniecia = $czasSchniecia;
    
        return $this;
    }

    /**
     * Get czasSchniecia
     *
     * @return string 
     */
    public function getCzasSchniecia()
    {
        return $this->czasSchniecia;
    }

    /**
     * Set tempMin
     *
     * @param integer $tempMin
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setTempMin($tempMin)
    {
        $this->tempMin = $tempMin;
    
        return $this;
    }

    /**
     * Get tempMin
     *
     * @return integer 
     */
    public function getTempMin()
    {
        return $this->tempMin;
    }

    /**
     * Set tempMax
     *
     * @param integer $tempMax
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setTempMax($tempMax)
    {
        $this->tempMax = $tempMax;
    
        return $this;
    }

    /**
     * Get tempMax
     *
     * @return integer 
     */
    public function getTempMax()
    {
        return $this->tempMax;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaProcesUtwardzaniaPowloki
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
     * Set procesUtwardzaniaPowloki
     *
     * @param ProcesUtwardzaniaPowloki $procesUtwardzaniaPowlok
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setProcesUtwardzaniaPowloki(ProcesUtwardzaniaPowloki $procesUtwardzaniaPowlok = null)
    {
        $this->procesUtwardzaniaPowloki = $procesUtwardzaniaPowlok;
    
        return $this;
    }

    /**
     * Get procesUtwardzaniaPowloki
     *
     * @return ProcesUtwardzaniaPowloki
     */
    public function getProcesUtwardzaniaPowloki()
    {
        return $this->procesUtwardzaniaPowloki;
    }
}