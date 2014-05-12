<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaProcesAplikacji
 *
 * @ORM\Table(name="filie_procesy_aplikacji")
 * @ORM\Entity
 */
class FiliaProcesAplikacji
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
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieProcesyAplikacji")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", nullable=false)
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ProcesAplikacji", inversedBy="filieProcesyAplikacji")
     * @ORM\JoinColumn(name="proces_aplikacji_id", referencedColumnName="id", nullable=false)
     */
    private $procesAplikacji;


    /**
     * @return string
     */
    public function __toString()
    {
        /**
         * @var ProcesAplikacji $procesAplikacji
         */
        $procesAplikacji = $this->procesAplikacji;
        return (string) $procesAplikacji->getNazwaProcesu();
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
     * @return FiliaProcesAplikacji
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
     * @return FiliaProcesAplikacji
     */
    public function setFilia(\DFP\EtapIBundle\Entity\Filia $filia = null)
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
     * Set procesAplikacji
     *
     * @param ProcesAplikacji $procesAplikacji
     * @return FiliaProcesAplikacji
     */
    public function setProcesAplikacji(ProcesAplikacji $procesAplikacji = null)
    {
        $this->procesAplikacji = $procesAplikacji;
    
        return $this;
    }

    /**
     * Get procesAplikacji
     *
     * @return ProcesAplikacji
     */
    public function getProcesAplikacji()
    {
        return $this->procesAplikacji;
    }
}