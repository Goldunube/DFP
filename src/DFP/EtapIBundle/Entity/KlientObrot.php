<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * KlientObrot
 *
 * @ORM\Table(name="klienci_obroty")
 * @ORM\Entity
 */
class KlientObrot
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
     * @ORM\Column(name="kwota", type="decimal", precision=10, scale=2)
     */
    private $kwota;


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
     * Set kwota
     *
     * @param string $kwota
     * @return KlientObrot
     */
    public function setKwota($kwota)
    {
        $this->kwota = $kwota;

        return $this;
    }

    /**
     * Get kwota
     *
     * @return string 
     */
    public function getKwota()
    {
        return $this->kwota;
    }
}
