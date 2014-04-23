<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaHandlowaProfSys
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class OfertaHandlowaProfSys
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
     * @return OfertaHandlowaProfSys
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
