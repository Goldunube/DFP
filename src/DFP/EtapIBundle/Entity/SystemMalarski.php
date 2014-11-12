<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SystemMalarski
 *
 * @ORM\Table(name="systemy_malarskie")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\SystemMalarskiRepository")
 */
class SystemMalarski
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
     * @ORM\Column(name="nazwa", type="string", length=255, nullable=false)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="komentarz", type="text", nullable=true)
     */
    private $komentarz;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\Column(name="warstwa_1")
     */
    private $warstwa1;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\Column(name="warstwa_2")
     */
    private $warstwa2;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\Column(name="warstwa_3")
     */
    private $warstwa3;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt")
     * @ORM\Column(name="warstwa_4")
     */
    private $warstwa4;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="ProfilSystem", mappedBy="systemMalarski", cascade={"persist"}, orphanRemoval=true)
     */
    private $profileSystemy;

    /**
     * @var boolean
     *
     * @ORM\Column(name="zatwierdzony", type="boolean", nullable=false)
     */
    private $zatwierdzony = false;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->profileSystemy= new ArrayCollection();
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
     * Set komentarz
     *
     * @param string $komentarz
     * @return SystemMalarski
     */
    public function setKomentarz($komentarz)
    {
        $this->komentarz = $komentarz;
    
        return $this;
    }

    /**
     * Get komentarz
     *
     * @return string
     */
    public function getKomentarz()
    {
        return $this->komentarz;
    }

    /**
     * Add profileSystemy
     *
     * @param ProfilSystem $profileSystemy
     * @return SystemMalarski
     */
    public function addProfileSystemy(ProfilSystem $profileSystemy)
    {
        $this->profileSystemy[] = $profileSystemy;
    
        return $this;
    }

    /**
     * Remove profileSystemy
     *
     * @param ProfilSystem $profileSystemy
     */
    public function removeProfileSystemy(ProfilSystem $profileSystemy)
    {
        $this->profileSystemy->removeElement($profileSystemy);
    }

    /**
     * Get profileSystemy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfileSystemy()
    {
        return $this->profileSystemy;
    }

    /**
     * @return boolean
     */
    public function getZatwierdzony()
    {
        return $this->zatwierdzony;
    }

    /**
     * @param boolean $zatwierdzony
     */
    public function setZatwierdzony($zatwierdzony)
    {
        $this->zatwierdzony = $zatwierdzony;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return SystemMalarski
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
     * Set warstwa1
     *
     * @param string $warstwa1
     * @return SystemMalarski
     */
    public function setWarstwa1($warstwa1)
    {
        $this->warstwa1 = $warstwa1;

        return $this;
    }

    /**
     * Get warstwa1
     *
     * @return string 
     */
    public function getWarstwa1()
    {
        return $this->warstwa1;
    }

    /**
     * Set warstwa2
     *
     * @param string $warstwa2
     * @return SystemMalarski
     */
    public function setWarstwa2($warstwa2)
    {
        $this->warstwa2 = $warstwa2;

        return $this;
    }

    /**
     * Get warstwa2
     *
     * @return string 
     */
    public function getWarstwa2()
    {
        return $this->warstwa2;
    }

    /**
     * Set warstwa3
     *
     * @param string $warstwa3
     * @return SystemMalarski
     */
    public function setWarstwa3($warstwa3)
    {
        $this->warstwa3 = $warstwa3;

        return $this;
    }

    /**
     * Get warstwa3
     *
     * @return string 
     */
    public function getWarstwa3()
    {
        return $this->warstwa3;
    }

    /**
     * Set warstwa4
     *
     * @param string $warstwa4
     * @return SystemMalarski
     */
    public function setWarstwa4($warstwa4)
    {
        $this->warstwa4 = $warstwa4;

        return $this;
    }

    /**
     * Get warstwa4
     *
     * @return string 
     */
    public function getWarstwa4()
    {
        return $this->warstwa4;
    }
}
