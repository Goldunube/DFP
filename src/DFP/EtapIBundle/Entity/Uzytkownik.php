<?php

namespace DFP\EtapIBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @ORM\OneToOne(targetEntity="ProfilUzytkownika", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="profil_id", referencedColumnName="id")
     */
    private $profilUzytkownika;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaUzytkownik", mappedBy="uzytkownik", cascade={"persist"})
     */
    protected $filieUzytkownicy;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaNotatka", mappedBy="notatka", cascade={"persist"})
     */
    protected $filieNotatki;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="NotatkaOsobista", mappedBy="uzytkownik", cascade={"persist"})
     */
    protected $notatkiOsobiste;


    public function __construct()
    {
        parent::__construct();
        $this->filieUzytkownicy = new ArrayCollection();
        $this->filieNotatki = new ArrayCollection();
        $this->notatkiOsobiste = new ArrayCollection();
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
     * @param ProfilUzytkownika $profilUzytkownika
     * @return Uzytkownik
     */
    public function setProfilUzytkownika(ProfilUzytkownika $profilUzytkownika = null)
    {
        $this->profilUzytkownika = $profilUzytkownika;
    
        return $this;
    }

    /**
     * Get profilUzytkownika
     *
     * @return ProfilUzytkownika
     */
    public function getProfilUzytkownika()
    {
        return $this->profilUzytkownika;
    }

    /**
     * Add filieUzytkownicy
     *
     * @param FiliaUzytkownik $filieUzytkownicy
     * @return Uzytkownik
     */
    public function addFilieUzytkownicy(FiliaUzytkownik $filieUzytkownicy)
    {
        $this->filieUzytkownicy[] = $filieUzytkownicy;
    
        return $this;
    }

    /**
     * Remove filieUzytkownicy
     *
     * @param FiliaUzytkownik $filieUzytkownicy
     */
    public function removeFilieUzytkownicy(FiliaUzytkownik $filieUzytkownicy)
    {
        $this->filieUzytkownicy->removeElement($filieUzytkownicy);
    }

    /**
     * Get filieUzytkownicy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieUzytkownicy()
    {
        return $this->filieUzytkownicy;
    }

    /**
     * Add filieNotatki
     *
     * @param FiliaNotatka $filieNotatki
     * @return Uzytkownik
     */
    public function addFilieNotatki(FiliaNotatka $filieNotatki)
    {
        $this->filieNotatki[] = $filieNotatki;
    
        return $this;
    }

    /**
     * Remove filieNotatki
     *
     * @param FiliaNotatka $filieNotatki
     */
    public function removeFilieNotatki(FiliaNotatka $filieNotatki)
    {
        $this->filieNotatki->removeElement($filieNotatki);
    }

    /**
     * Get filieNotatki
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieNotatki()
    {
        return $this->filieNotatki;
    }

    /**
     * Add notatkiOsobiste
     *
     * @param NotatkaOsobista $notatkiOsobiste
     * @return Uzytkownik
     */
    public function addNotatkiOsobiste(NotatkaOsobista $notatkiOsobiste)
    {
        $this->notatkiOsobiste[] = $notatkiOsobiste;
    
        return $this;
    }

    /**
     * Remove notatkiOsobiste
     *
     * @param NotatkaOsobista $notatkiOsobiste
     */
    public function removeNotatkiOsobiste(NotatkaOsobista $notatkiOsobiste)
    {
        $this->notatkiOsobiste->removeElement($notatkiOsobiste);
    }

    /**
     * Get notatkiOsobiste
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotatkiOsobiste()
    {
        return $this->notatkiOsobiste;
    }
}