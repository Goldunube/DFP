<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * GrupaKlientow
 *
 * @ORM\Table(name="grupy_klientow")
 * @ORM\Entity
 */
class GrupaKlientow
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
     * @ORM\Column(name="nazwa_grupy", type="string", length=80)
     */
    private $nazwaGrupy;

    /**
     * @var integer
     *
     * @ORM\ManyToMany(targetEntity="Klient", mappedBy="grupyKlientow")
     */
    private $klienci;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->klienci = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getNazwaGrupy();
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
     * Set nazwaGrupy
     *
     * @param string $nazwaGrupy
     * @return GrupaKlientow
     */
    public function setNazwaGrupy($nazwaGrupy)
    {
        $this->nazwaGrupy = $nazwaGrupy;

        return $this;
    }
    /**
     * Get nazwaGrupy
     *
     * @return string
     */
    public function getNazwaGrupy()
    {
        return $this->nazwaGrupy;
    }

    /**
     * Add klienci
     *
     * @param Klient $klienci
     * @return GrupaKlientow
     */
    public function addKlienci(Klient $klienci)
    {
        $this->klienci[] = $klienci;
    
        return $this;
    }

    /**
     * Remove klienci
     *
     * @param Klient $klienci
     */
    public function removeKlienci(Klient $klienci)
    {
        $this->klienci->removeElement($klienci);
    }

    /**
     * Get klienci
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getKlienci()
    {
        return $this->klienci;
    }
}