<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * MaterialUzupelniajacy
 *
 * @ORM\Table(name="materialy_uzupelniajace")
 * @ORM\Entity
 */
class MaterialUzupelniajacy
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
     * @ORM\Column(name="nazwa", type="string", length=80)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", nullable=true)
     */
    private $opis;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaMaterialUzupelniajacy", mappedBy="materialUzupelniajacy", cascade={"persist"})
     */
    private $filieMaterialyUzupelniajace;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filieMaterialyUzupelniajace = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getNazwa();
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
     * Set nazwa
     *
     * @param string $nazwa
     * @return MaterialUzupelniajacy
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    
        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set opis
     *
     * @param string $opis
     * @return MaterialUzupelniajacy
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
     * Add filieMaterialyUzupelniajace
     *
     * @param FiliaMaterialUzupelniajacy $filieMaterialyUzupelniajace
     * @return MaterialUzupelniajacy
     */
    public function addFilieMaterialyUzupelniajace(FiliaMaterialUzupelniajacy $filieMaterialyUzupelniajace)
    {
        $this->filieMaterialyUzupelniajace[] = $filieMaterialyUzupelniajace;

        return $this;
    }

    /**
     * Remove filieMaterialyUzupelniajace
     *
     * @param FiliaMaterialUzupelniajacy $filieMaterialyUzupelniajace
     */
    public function removeFilieMaterialyUzupelniajace(FiliaMaterialUzupelniajacy $filieMaterialyUzupelniajace)
    {
        $this->filieMaterialyUzupelniajace->removeElement($filieMaterialyUzupelniajace);
    }

    /**
     * Get filieMaterialyUzupelniajace
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilieMaterialyUzupelniajace()
    {
        return $this->filieMaterialyUzupelniajace;
    }
}