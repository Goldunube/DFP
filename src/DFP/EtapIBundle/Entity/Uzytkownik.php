<?php

namespace DFP\EtapIBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * Uzytkownik
 *
 * @ORM\Table(name="uzytkownicy")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\UzytkownikRepository")
 */
class Uzytkownik extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="imie", type="string", length=15, nullable=true)
     */
    private $imie;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=25, nullable=true)
     */
    private $nazwisko;

    /**
     * @ORM\OneToOne(targetEntity="ProfilUzytkownika")
     * @ORM\JoinColumn(name="profil_id", referencedColumnName="id")
     */
    private $profilUzytkownika;


    public function __construct()
    {
        parent::__construct();
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
     * Set imie
     *
     * @param string $imie
     * @return Uzytkownik
     */
    public function setImie($imie)
    {
        $this->imie = $imie;
    
        return $this;
    }

    /**
     * Get imie
     *
     * @return string 
     */
    public function getImie()
    {
        return $this->imie;
    }

    /**
     * Set nazwisko
     *
     * @param string $nazwisko
     * @return Uzytkownik
     */
    public function setNazwisko($nazwisko)
    {
        $this->nazwisko = $nazwisko;
    
        return $this;
    }

    /**
     * Get nazwisko
     *
     * @return string 
     */
    public function getNazwisko()
    {
        return $this->nazwisko;
    }

    /**
     * Set profilUzytkownika
     *
     * @param \DFP\EtapIBundle\Entity\ProfilUzytkownika $profilUzytkownika
     * @return Uzytkownik
     */
    public function setProfilUzytkownika(\DFP\EtapIBundle\Entity\ProfilUzytkownika $profilUzytkownika = null)
    {
        $this->profilUzytkownika = $profilUzytkownika;
    
        return $this;
    }

    /**
     * Get profilUzytkownika
     *
     * @return \DFP\EtapIBundle\Entity\ProfilUzytkownika 
     */
    public function getProfilUzytkownika()
    {
        return $this->profilUzytkownika;
    }
}