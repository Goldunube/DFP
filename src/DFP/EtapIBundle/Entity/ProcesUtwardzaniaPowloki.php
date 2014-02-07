<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcesUtwardzaniaPowloki
 *
 * @ORM\Table(name="procesy_utwardzania_powloki")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProcesUtwardzaniaPowlokiRepository")
 */
class ProcesUtwardzaniaPowloki
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
     * @ORM\Column(name="nazwaProcesu", type="string", length=150)
     */
    private $nazwaProcesu;

    /**
     * @var string
     *
     * @ORM\Column(name="ops", type="text")
     */
    private $ops;


    public function __toString()
    {
        return (string) $this->getNazwaProcesu();
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
     * Set nazwaProcesu
     *
     * @param string $nazwaProcesu
     * @return ProcesUtwardzaniaPowloki
     */
    public function setNazwaProcesu($nazwaProcesu)
    {
        $this->nazwaProcesu = $nazwaProcesu;
    
        return $this;
    }

    /**
     * Get nazwaProcesu
     *
     * @return string 
     */
    public function getNazwaProcesu()
    {
        return $this->nazwaProcesu;
    }

    /**
     * Set ops
     *
     * @param string $ops
     * @return ProcesUtwardzaniaPowloki
     */
    public function setOps($ops)
    {
        $this->ops = $ops;
    
        return $this;
    }

    /**
     * Get ops
     *
     * @return string 
     */
    public function getOps()
    {
        return $this->ops;
    }
}
