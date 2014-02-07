<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @ORM\Column(name="opis", type="text")
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesUtwardzaniaPowloki", mappedBy="procesUtwardzaniaPowloki", cascade={"persist"})
     */
    private $filieProcesyUtwardzaniaPowlok;


    public function __construct()
    {
        $this->filieProcesyUtwardzaniaPowlok = new ArrayCollection();
    }

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
     * Set opis
     *
     * @param string $opis
     * @return ProcesUtwardzaniaPowloki
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
     * Add filieProcesyUtwardzaniaPowlok
     *
     * @param FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok
     * @return ProcesUtwardzaniaPowloki
     */
    public function addFilieProcesyUtwardzaniaPowlok(FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok)
    {
        $this->filieProcesyUtwardzaniaPowlok[] = $filieProcesyUtwardzaniaPowlok;
    
        return $this;
    }

    /**
     * Remove filieProcesyUtwardzaniaPowlok
     *
     * @param FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok
     */
    public function removeFilieProcesyUtwardzaniaPowlok(FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok)
    {
        $this->filieProcesyUtwardzaniaPowlok->removeElement($filieProcesyUtwardzaniaPowlok);
    }

    /**
     * Get filieProcesyUtwardzaniaPowlok
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieProcesyUtwardzaniaPowlok()
    {
        return $this->filieProcesyUtwardzaniaPowlok;
    }
}