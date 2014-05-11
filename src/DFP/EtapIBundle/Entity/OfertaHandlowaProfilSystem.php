<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaHandlowaProfilSystem
 *
 * @ORM\Table(name="oferty_profile_systemy")
 * @ORM\Entity
 */
class OfertaHandlowaProfilSystem
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
     * @ORM\Column(name="uwagi", type="text", nullable=true)
     */
    private $uwagi;

    /**
     * @ORM\ManyToOne(targetEntity="OfertaHandlowa", inversedBy="ofertyProfileSystemy",cascade={"persist"})
     * @ORM\JoinColumn(name="oferta_handlowa_id", referencedColumnName="id", nullable=false)
     */
    private $ofertaHandlowa;

    /**
     * @ORM\ManyToOne(targetEntity="ProfilSystem", inversedBy="ofertyProfileSystemy",cascade={"persist"})
     * @ORM\JoinColumn(name="profil_system_id", referencedColumnName="id", nullable=false)
     */
    private $profilSystem;


    /**
     *
     */
    public function __construct()
    {
        $this->profilSystem = new ArrayCollection();
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
     * Set uwagi
     *
     * @param string $uwagi
     * @return OfertaHandlowaProfilSystem
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;
    
        return $this;
    }

    /**
     * Get uwagi
     *
     * @return string 
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }

    /**
     * Set ofertaHandlowa
     *
     * @param OfertaHandlowa $ofertaHandlowa
     * @return OfertaHandlowaProfilSystem
     */
    public function setOfertaHandlowa(OfertaHandlowa $ofertaHandlowa)
    {
        $this->ofertaHandlowa = $ofertaHandlowa;
    
        return $this;
    }

    /**
     * Get ofertaHandlowa
     *
     * @return OfertaHandlowa
     */
    public function getOfertaHandlowa()
    {
        return $this->ofertaHandlowa;
    }

    /**
     * Set profilSystem
     *
     * @param ProfilSystem $profilSystem
     * @return OfertaHandlowaProfilSystem
     */
    public function setProfilSystem(ProfilSystem $profilSystem)
    {
        $this->profilSystem = $profilSystem;

        return $this;
    }

    /**
     * Get profilSystem
     *
     * @return ProfilSystem
     */
    public function getProfilSystem()
    {
        return $this->profilSystem;
    }

    /**
     * Add profilSystem
     *
     * @param ProfilSystem $profilSystem
     */
    public function addProfilSystem(ProfilSystem $profilSystem)
    {
        $this->profilSystem->add($profilSystem);
    }

    /**
     * Remove profilSystem
     *
     * @param ProfilSystem $profilSystem
     */
    public function removeProfilSystem(ProfilSystem $profilSystem)
    {
        $this->profilSystem->removeElement($profilSystem);
    }
}