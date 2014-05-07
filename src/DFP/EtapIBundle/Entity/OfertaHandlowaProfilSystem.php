<?php

namespace DFP\EtapIBundle\Entity;

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
     * @ORM\Column(name="uwagi", type="text")
     */
    private $uwagi;

    /**
     * @ORM\ManyToOne(targetEntity="OfertaHandlowa", inversedBy="ofertyProfileSystemy")
     * @ORM\JoinColumn(name="oferta_handlowa_id", referencedColumnName="id", nullable=false)
     */
    private $ofertaHandlowa;


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
}
