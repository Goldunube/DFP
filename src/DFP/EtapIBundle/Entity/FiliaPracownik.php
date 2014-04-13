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
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon_1", type="string", length=20, nullable=true)
     */
    private $telefon1;

    /**
     * @var string
     *
     * @ORM\Column(name="telefon_2", type="string", length=20, nullable=true)
     */
    private $telefon2;

    /**
     * @var string
     *
     * @ORM\Column(name="fax", type="string", length=20, nullable=true)
     */
    private $fax;

    /**
     * @var string
     *
     * @ORM\Column(name="mobile", type="string", length=20, nullable=true)
     */
    private $mobile;

    /**
     * @var string
     *
     * @ORM\Column(name="skype", type="string", length=255, nullable=true)
     */
    private $skype;

    /**
     * @var string
     *
     * @ORM\Column(name="notatka", type="text", nullable=true)
     */
    private $notatka;

    /**
     * @var boolean
     *
     * @ORM\Column(name="osoba_kontaktowa", type="boolean")
     */
    private $osobaKontaktowa;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filiePracownicy")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $filia;


    public function __toString()
    {
        return (string) '<span title="'.$this->buildTitle().'">'.$this->getImie().' '.$this->getNazwisko().'</span>';
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

    /**
     * Get filia
     *
     * @return Filia
     */
    public function getFilia()
    {
        return $this->filia;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaPracownik
     */
    public function setFilia(Filia $filia)
    {
        $this->filia = $filia;

        return $this;
    }

    /**
     * Funkcja prywatna służąca do budowania title w tagu FiliePracownicy
     *
     * @return string
     */
    private function buildTitle()
    {
        $stanowisko = $this->getStanowisko();
        $tel1 = $this->getTelefon1();
        $tel2 = $this->getTelefon2();
        $mobile = $this->getMobile();
        $email = $this->getEmail();
        $skype = $this->getSkype();
        $notatka = $this->getNotatka();

        $html = <<<HTML
            <table>
                <tr>
                    <th>Stanowisko:</th>
                    <td>$stanowisko</td>
                </tr>
                <tr>
                    <th>Telefon 1:</th>
                    <td>$tel1</td>
                </tr>
                <tr>
                    <th>Telefon 2:</th>
                    <td>$tel2</td>
                </tr>
                <tr>
                    <th>Mobile:</th>
                    <td>$mobile</td>
                </tr>
                <tr>
                    <th>e-mail</th>
                    <td>$email</td>
                </tr>
                <tr>
                    <th>Skype:</th>
                    <td>$skype</td>
                </tr>
                <tr>
                    <th>Notatki:</th>
                    <td>$notatka</td>
                </tr>
            </table>
HTML;
        return $html;
    }
}