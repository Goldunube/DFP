<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilDzialalnosci
 *
 * @ORM\Table(name="profile_dzialalnosci")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProfilDzialalnosciRepository")
 */
class ProfilDzialalnosci
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
     * @ORM\Column(name="nazwa_profilu", type="string", length=60)
     */
    private $nazwaProfilu;

    /**
     * @var boolean
     *
     * @ORM\Column(name="zweryfikowany", type="boolean")
     */
    private $zweryfikowany;

    /**
     * @ORM\ManyToMany(targetEntity="Klient", mappedBy="profileDzialalnosci")
     *
     */
    private $klienci;

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->klienci = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getNazwaProfilu();
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
     * Set nazwaProfilu
     *
     * @param string $nazwaProfilu
     * @return ProfilDzialalnosci
     */
    public function setNazwaProfilu($nazwaProfilu)
    {
        $this->nazwaProfilu = $nazwaProfilu;
    
        return $this;
    }

    /**
     * Get nazwaProfilu
     *
     * @return string 
     */
    public function getNazwaProfilu()
    {
        return $this->nazwaProfilu;
    }

    /**
     * Set zweryfikowany
     *
     * @param boolean $zweryfikowany
     * @return ProfilDzialalnosci
     */
    public function setZweryfikowany($zweryfikowany)
    {
        $this->zweryfikowany = $zweryfikowany;
    
        return $this;
    }

    /**
     * Get zweryfikowany
     *
     * @return boolean 
     */
    public function getZweryfikowany()
    {
        return $this->zweryfikowany;
    }

    /**
     * Add klienci
     *
     * @param \DFP\EtapIBundle\Entity\klient $klienci
     * @return ProfilDzialalnosci
     */
    public function addKlienci(\DFP\EtapIBundle\Entity\klient $klienci)
    {
        $this->klienci[] = $klienci;

        return $this;
    }

    /**
     * Remove klienci
     *
     * @param \DFP\EtapIBundle\Entity\klient $klienci
     */
    public function removeKlienci(\DFP\EtapIBundle\Entity\klient $klienci)
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