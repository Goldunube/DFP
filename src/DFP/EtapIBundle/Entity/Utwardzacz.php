<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utwardzacz
 *
 * @ORM\Table(name="utwardzacze")
 * @ORM\Entity
 */
class Utwardzacz
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
     */
    private $nazwa;


    /**
     * To String
     *
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
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * @param string $nazwa
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;
    }

}
