<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ProcesPrzygotowaniaPowierzchni
 *
 * @ORM\Table(name="procesy_przygotowania_powierzchni")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProcesPrzygotowaniaPowierzchniRepository")
 */
class ProcesPrzygotowaniaPowierzchni
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
     * @ORM\Column(name="opis", type="text", nullable=true)
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesPrzygotowaniaPowierzchni", mappedBy="procesPrzygotowaniaPowierzchni", cascade={"persist"})
     */
    private $filieProcesyPrzygotowaniaPowierzchni;


    public function __construct()
    {
        $this->filieProcesyPrzygotowaniaPowierzchni = new ArrayCollection();
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
     * @return ProcesPrzygotowaniaPowierzchni
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
     * @return ProcesPrzygotowaniaPowierzchni
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
     * Add filieProcesyPrzygotowaniaPowierzchni
     *
     * @param FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni
     * @return ProcesPrzygotowaniaPowierzchni
     */
    public function addFilieProcesyPrzygotowaniaPowierzchni(
        FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni)
    {
        $this->filieProcesyPrzygotowaniaPowierzchni[] = $filieProcesyPrzygotowaniaPowierzchni;
    
        return $this;
    }

    /**
     * Remove filieProcesyPrzygotowaniaPowierzchni
     *
     * @param FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni
     */
    public function removeFilieProcesyPrzygotowaniaPowierzchni(
        FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni)
    {
        $this->filieProcesyPrzygotowaniaPowierzchni->removeElement($filieProcesyPrzygotowaniaPowierzchni);
    }

    /**
     * Get filieProcesyPrzygotowaniaPowierzchni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieProcesyPrzygotowaniaPowierzchni()
    {
        return $this->filieProcesyPrzygotowaniaPowierzchni;
    }
}