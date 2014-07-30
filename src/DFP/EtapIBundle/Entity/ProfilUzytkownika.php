<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilUzytkownika
 *
 * @ORM\Table(name="profile_uzytkownikow")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProfilUzytkownikaRepository")
 */
class ProfilUzytkownika
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
     * @ORM\Column(name="plec", type="string", length=15, nullable=true)
     */
    private $plec;

    /**
     * @var string
     *
     * @ORM\Column(name="stanowisko", type="string", length=45, nullable=true)
     */
    private $stanowisko;

    /**
     * @var string
     *
     * @ORM\Column(name="zainteresowania", type="text", nullable=true)
     */
    private $zainteresowania;

    /**
     * @var string
     *
     * @ORM\Column(name="miejscowosc", type="string", length=45, nullable=true)
     */
    private $miejscowosc;

    /**
     * @var string
     *
     * @ORM\Column(name="kodPocztowy", type="string", length=5, nullable=true)
     */
    private $kodPocztowy;

    /**
     * @var string
     *
     * @ORM\Column(name="ulica", type="string", length=150, nullable=true)
     */
    private $ulica;

    /**
     * @var string
     *
     * @ORM\Column(name="korporacja", type="string", length=4, nullable=true)
     */
    private $korporacja;

    /**
     * @var string
     *
     * @ORM\Column(name="telefonStacjonarny", type="string", length=9, nullable=true)
     */
    private $telefonStacjonarny;

    /**
     * @var string
     *
     * @ORM\Column(name="komorka", type="string", length=9, nullable=true)
     */
    private $komorka;


    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=255, nullable=true)
     */
    private $skype;


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
     * Set plec
     *
     * @param string $plec
     * @return ProfilUzytkownika
     */
    public function setPlec($plec)
    {
        $this->plec = $plec;
    
        return $this;
    }

    /**
     * Get plec
     *
     * @return string 
     */
    public function getPlec()
    {
        return $this->plec;
    }

    /**
     * Set stanowisko
     *
     * @param string $stanowisko
     * @return ProfilUzytkownika
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
     * Set zainteresowania
     *
     * @param string $zainteresowania
     * @return ProfilUzytkownika
     */
    public function setZainteresowania($zainteresowania)
    {
        $this->zainteresowania = $zainteresowania;
    
        return $this;
    }

    /**
     * Get zainteresowania
     *
     * @return string 
     */
    public function getZainteresowania()
    {
        return $this->zainteresowania;
    }

    /**
     * Set miejscowosc
     *
     * @param string $miejscowosc
     * @return ProfilUzytkownika
     */
    public function setMiejscowosc($miejscowosc)
    {
        $this->miejscowosc = $miejscowosc;
    
        return $this;
    }

    /**
     * Get miejscowosc
     *
     * @return string 
     */
    public function getMiejscowosc()
    {
        return $this->miejscowosc;
    }

    /**
     * Set kodPocztowy
     *
     * @param string $kodPocztowy
     * @return ProfilUzytkownika
     */
    public function setKodPocztowy($kodPocztowy)
    {
        $this->kodPocztowy = $kodPocztowy;
    
        return $this;
    }

    /**
     * Get kodPocztowy
     *
     * @return string 
     */
    public function getKodPocztowy()
    {
        return $this->kodPocztowy;
    }

    /**
     * Set ulica
     *
     * @param string $ulica
     * @return ProfilUzytkownika
     */
    public function setUlica($ulica)
    {
        $this->ulica = $ulica;
    
        return $this;
    }

    /**
     * Get ulica
     *
     * @return string 
     */
    public function getUlica()
    {
        return $this->ulica;
    }

    /**
     * @return string
     */
    public function getKorporacja()
    {
        return $this->korporacja;
    }

    /**
     * @param string $korporacja
     */
    public function setKorporacja($korporacja)
    {
        $korporacja = str_replace(array(' ','-','_'),'',$korporacja);
        $this->korporacja = $korporacja;
    }

    /**
     * @return string
     */
    public function getTelefonStacjonarny()
    {
        return $this->telefonStacjonarny;
    }

    /**
     * @param string $telefonStacjonarny
     */
    public function setTelefonStacjonarny($telefonStacjonarny)
    {
        $telefonStacjonarny = str_replace(array(' ', '-'),'',$telefonStacjonarny);
        $this->telefonStacjonarny = $telefonStacjonarny;
    }

    /**
     * @return string
     */
    public function getKomorka()
    {
        return $this->komorka;
    }

    /**
     * @param string $komorka
     */
    public function setKomorka($komorka)
    {
        $komorka = str_replace('-','',$komorka);
        $this->komorka = $komorka;
    }

    /**
     * @return string
     */
    public function getSkype()
    {
        return $this->skype;
    }

    /**
     * @param string $skype
     */
    public function setSkype($skype)
    {
        $this->skype = $skype;
    }
}