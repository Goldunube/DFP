<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaPracownik
 *
 * @ORM\Table(name="pracownicy_filii")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaPracownikRepository")
 */
class FiliaPracownik
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
     * @ORM\Column(name="imie", type="string", length=15)
     */
    private $imie;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwisko", type="string", length=25)
     */
    private $nazwisko;

    /**
     * @var string
     *
     * @ORM\Column(name="stanowisko", type="string", length=60)
     */
    private $stanowisko;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon_1", type="string", length=20)
     */
    private $telefon1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon_2", type="string", length=20)
     */
    private $telefon2;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=20)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=20)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=255)
     */
    private $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="notatka", type="text")
     */
    private $notatka;

    /**
     * @var boolean
     *
     * @ORM\Column(name="osoba_kontaktowa", type="boolean")
     */
    private $osobaKontaktowa;


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
     * @return FiliaPracownik
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
     * @return FiliaPracownik
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
     * Set stanowisko
     *
     * @param string $stanowisko
     * @return FiliaPracownik
     */
    public function setStanowisko($stanowisko)
    {
        $this->stanowisko = $stanowisko;
    
        return $this;
    }

    /**
     * Get stanowisko
     *
     * @return string 
     */
    public function getStanowisko()
    {
        return $this->stanowisko;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return FiliaPracownik
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telefon1
     *
     * @param string $telefon1
     * @return FiliaPracownik
     */
    public function setTelefon1($telefon1)
    {
        $this->telefon1 = $telefon1;
    
        return $this;
    }

    /**
     * Get telefon1
     *
     * @return string 
     */
    public function getTelefon1()
    {
        return $this->telefon1;
    }

    /**
     * Set telefon2
     *
     * @param string $telefon2
     * @return FiliaPracownik
     */
    public function setTelefon2($telefon2)
    {
        $this->telefon2 = $telefon2;
    
        return $this;
    }

    /**
     * Get telefon2
     *
     * @return string 
     */
    public function getTelefon2()
    {
        return $this->telefon2;
    }

    /**
     * Set fax
     *
     * @param string $fax
     * @return FiliaPracownik
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
    
        return $this;
    }

    /**
     * Get fax
     *
     * @return string 
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * Set mobile
     *
     * @param string $mobile
     * @return FiliaPracownik
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    
        return $this;
    }

    /**
     * Get mobile
     *
     * @return string 
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set skype
     *
     * @param string $skype
     * @return FiliaPracownik
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
    
        return $this;
    }

    /**
     * Get skype
     *
     * @return string 
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * Set notatka
     *
     * @param string $notatka
     * @return FiliaPracownik
     */
    public function setNotatka($notatka)
    {
        $this->notatka = $notatka;
    
        return $this;
    }

    /**
     * Get notatka
     *
     * @return string 
     */
    public function getNotatka()
    {
        return $this->notatka;
    }

    /**
     * Set osobaKontaktowa
     *
     * @param boolean $osobaKontaktowa
     * @return FiliaPracownik
     */
    public function setOsobaKontaktowa($osobaKontaktowa)
    {
        $this->osobaKontaktowa = $osobaKontaktowa;
    
        return $this;
    }

    /**
     * Get osobaKontaktowa
     *
     * @return boolean 
     */
    public function getOsobaKontaktowa()
    {
        return $this->osobaKontaktowa;
    }
}