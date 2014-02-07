<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProcesAplikacji
 *
 * @ORM\Table(name="procesy_aplikacji")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProcesAplikacjiRepository")
 */
class ProcesAplikacji
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
     * @ORM\Column(name="opis", type="text")
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesAplikacji", mappedBy="procesAplikacji", cascade={"persist"})
     */
    private $filieProcesyAplikacji;


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
     * @return ProcesAplikacji
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
     * Set opis
     *
     * @param string $opis
     * @return ProcesAplikacji
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
