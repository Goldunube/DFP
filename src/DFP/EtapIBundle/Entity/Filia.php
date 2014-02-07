<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Filia
 *
 * @ORM\Table(name="filie")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaRepository")
 */
class Filia
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
     * @ORM\Column(name="nazwa_filii", type="string", length=255)
     */
    private $nazwaFilii;

    /**
     * @var string
     *
     * @ORM\Column(name="wojewodztwo", type="string", length=45)
     */
    private $wojewodztwo;

    /**
     * @var string
     *
     * @ORM\Column(name="miejscowosc", type="string", length=120)
     */
    private $miejscowosc;

    /**
     * @var string
     *
     * @ORM\Column(name="kod_pocztowy", type="string", length=10)
     */
    private $kodPocztowy;

    /**
     * @var string
     *
     * @ORM\Column(name="ulica", type="string", length=150)
     */
    private $ulica;

    /**
     * @var boolean
     */
    private $aktywny;

    /**
     * @var text
     *
     * @ORM\Column(name="matlak_dotychczas", type="text")
     */
    private $matlakDotychczas;
    /**
     * @var string
     *
     * @ORM\Column(name="zuzycie_materialow", type="string", length=255)
     */
    private $zuzycieMaterialow;

    /**
     * @ORM\ManyToOne(targetEntity="Klient", inversedBy="filie")
     *
     * @ORM\JoinColumn(name="klient_id", referencedColumnName="id", nullable=false)
     */
    protected $klient;

    /**
     * @ORM\OneToMany(targetEntity="FiliaUzytkownik", mappedBy="filia", cascade={"persist"})
     */
    private $filieUzytkownicy;

    /**
     * @ORM\ManyToMany(targetEntity="ProfilDzialalnosci", inversedBy="filie")
     * @ORM\JoinTable(name="filie_profile_dzialalnosci",
     *      joinColumns={@ORM\JoinColumn(name="filia_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="profil_id", referencedColumnName="id")}
     * )
     */
    private $profileDzialalnosci;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesPrzygotowaniaPowierzchni", mappedBy="filia", cascade={"persist"})
     */
    private $filieProcesyPrzygotowaniaPowierzchni;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesAplikacji", mappedBy="filia", cascade={"persist"})
     */
    private $filieProcesyAplikacji;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesUtwardzaniaPowloki", mappedBy="filia", cascade={"persist"})
     */
    private $filieProcesyUtwardzaniaPowlok;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaWymaganiaProduktu", mappedBy="filia", cascade={"persist"})
     */
    private $filieWymaganiaProduktow;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaWymaganiaPowloki", mappedBy="filia", cascade={"persist"})
     */
    private $filieWymaganiaPowlok;


    public function __construct()
    {
        $this->filieUzytkownicy = new ArrayCollection();
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
     * Set nazwaFilii
     *
     * @param string $nazwaFilii
     * @return Filia
     */
    public function setNazwaFilii($nazwaFilii)
    {
        $this->nazwaFilii = $nazwaFilii;
    
        return $this;
    }

    /**
     * Get nazwaFilii
     *
     * @return string 
     */
    public function getNazwaFilii()
    {
        return $this->nazwaFilii;
    }

    /**
     * Set wojewodztwo
     *
     * @param string $wojewodztwo
     * @return Filia
     */
    public function setWojewodztwo($wojewodztwo)
    {
        $this->wojewodztwo = $wojewodztwo;
    
        return $this;
    }

    /**
     * Get wojewodztwo
     *
     * @return string 
     */
    public function getWojewodztwo()
    {
        return $this->wojewodztwo;
    }

    /**
     * Set miejscowosc
     *
     * @param string $miejscowosc
     * @return Filia
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
     * @return Filia
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
     * @return Filia
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
     * Set klient
     *
     * @param Klient $klient
     * @return Filia
     */
    public function setKlient(Klient $klient = null)
    {
        $this->klient = $klient;
//        $klient->addFilie($this);
        return $this;
    }

    /**
     * Get klient
     *
     * @return Klient
     */
    public function getKlient()
    {
        return $this->klient;
    }

    /**
     * Add filieUzytkownicy
     *
     * @param FiliaUzytkownik $filieUzytkownicy
     * @return Filia
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
}