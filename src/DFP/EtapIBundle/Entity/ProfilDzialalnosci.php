<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
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
     * @var string
     *
     * @ORM\Column(name="info", type="text", nullable=true)
     */
    private $info;

    /**
     * @ORM\ManyToMany(targetEntity="Filia", mappedBy="profileDzialalnosci")
     *
     */
    private $filie;

    /**
     * @ORM\OneToMany(targetEntity="ProfilSystem", mappedBy="profilDzialalnosci", cascade={"persist"}, orphanRemoval=true)
     */
    private $profileSystemy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filie = new ArrayCollection();
        $this->profileSystemy = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getNazwaProfilu();
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
     * Add filie
     *
     * @param Filia $filie
     * @return ProfilDzialalnosci
     */
    public function addFilie(Filia $filie)
    {
        $this->filie[] = $filie;
    
        return $this;
    }

    /**
     * Remove filie
     *
     * @param Filia $filie
     */
    public function removeFilie(Filia $filie)
    {
        $this->filie->removeElement($filie);
    }

    /**
     * Get filie
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilie()
    {
        return $this->filie;
    }

    /**
     * Set info
     *
     * @param string $info
     * @return ProfilDzialalnosci
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Add profileSystemy
     *
     * @param ProfilSystem $profileSystemy
     * @return ProfilDzialalnosci
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
}