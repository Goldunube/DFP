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
     *
     * @ORM\Column(name="aktywna", type="boolean")
     */
    private $aktywna = true;

    /**
     * @var string
     *
     * @ORM\Column(name="matlak_dotychczas", type="text", nullable=true)
     */
    private $matlakDotychczas;
    /**
     * @var string
     *
     * @ORM\Column(name="zuzycie_materialow", type="text", nullable=true)
     */
    private $zuzycieMaterialow;

    /**
     * @var string
     *
     * @ORM\Column(name="stosowana_kolorystyka", type="text", nullable=true)
     */
    private $kolorystyka;

    /**
     * @var string
     *
     * @ORM\Column(name="adnotacje", type="text", nullable=true)
     */
    private $adnotacja;

    /**
     * @ORM\ManyToOne(targetEntity="Klient", inversedBy="filie")
     *
     * @ORM\JoinColumn(name="klient_id", referencedColumnName="id", nullable=false)
     */
    protected $klient;

    /**
     * @ORM\OneToMany(targetEntity="FiliaUzytkownik", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    private $filieUzytkownicy;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaNotatka", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieNotatki;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaZobowiazanie", mappedBy="filia", cascade={"persist"})
     */
    protected $zobowiazania;

    /**
     * @ORM\ManyToMany(targetEntity="ProfilDzialalnosci", inversedBy="filie")
     * @ORM\JoinTable(name="filie_profile_dzialalnosci",
     *      joinColumns={@ORM\JoinColumn(name="filia_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="profil_id", referencedColumnName="id")}
     * )
     */
    protected $profileDzialalnosci;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesPrzygotowaniaPowierzchni", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieProcesyPrzygotowaniaPowierzchni;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesAplikacji", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieProcesyAplikacji;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaProcesUtwardzaniaPowloki", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieProcesyUtwardzaniaPowlok;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaWymaganiaProduktu", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieWymaganiaProduktow;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaWymaganiaPowloki", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieWymaganiaPowlok;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="FiliaRodzajPowierzchni", mappedBy="filia", cascade={"persist"}, orphanRemoval=true)
     */
    protected $filieRodzajePowierzchni;


    public function __construct()
    {
        $this->filieUzytkownicy = new ArrayCollection();
        $this->profileDzialalnosci = new ArrayCollection();
        $this->filieProcesyPrzygotowaniaPowierzchni = new ArrayCollection();
        $this->filieRodzajePowierzchni = new ArrayCollection();
        $this->filieProcesyAplikacji = new ArrayCollection();
        $this->filieProcesyUtwardzaniaPowlok = new ArrayCollection();
        $this->filieWymaganiaProduktow = new ArrayCollection();
        $this->filieWymaganiaPowlok = new ArrayCollection();
        $this->zobowiazania = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getNazwaFilii();
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

    /**
     * Set matlakDotychczas
     *
     * @param string $matlakDotychczas
     * @return $this
     */
    public function setMatlakDotychczas($matlakDotychczas)
    {
        $this->matlakDotychczas = $matlakDotychczas;
    
        return $this;
    }

    /**
     * Get matlakDotychczas
     *
     * @return string 
     */
    public function getMatlakDotychczas()
    {
        return $this->matlakDotychczas;
    }

    /**
     * Set zuzycieMaterialow
     *
     * @param string $zuzycieMaterialow
     * @return Filia
     */
    public function setZuzycieMaterialow($zuzycieMaterialow)
    {
        $this->zuzycieMaterialow = $zuzycieMaterialow;
    
        return $this;
    }

    /**
     * Get zuzycieMaterialow
     *
     * @return string 
     */
    public function getZuzycieMaterialow()
    {
        return $this->zuzycieMaterialow;
    }

    /**
     * Set kolorystyka
     *
     * @param string $kolorystyka
     * @return Filia
     */
    public function setKolorystyka($kolorystyka)
    {
        $this->kolorystyka = $kolorystyka;

        return $this;
    }

    /**
     * Get kolorystyka
     *
     * @return string
     */
    public function getKolorystyka()
    {
        return $this->kolorystyka;
    }

    /**
     * Add filieNotatki
     *
     * @param FiliaNotatka $filieNotatki
     * @return Filia
     */
    public function addFilieNotatki(FiliaNotatka $filieNotatki)
    {
        $this->filieNotatki[] = $filieNotatki;
//        $filieNotatki->setFilia($this);
    
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
     * Add zobowiazania
     *
     * @param FiliaZobowiazanie $zobowiazania
     * @return $this
     */
    public function addZobowiazania(FiliaZobowiazanie $zobowiazania)
    {
        $this->zobowiazania[] = $zobowiazania;
    
        return $this;
    }

    /**
     * Remove zobowiazania
     *
     * @param FiliaZobowiazanie $zobowiazania
     */
    public function removeZobowiazania(FiliaZobowiazanie $zobowiazania)
    {
        $this->zobowiazania->removeElement($zobowiazania);
    }

    /**
     * Get zobowiazania
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getZobowiazania()
    {
        return $this->zobowiazania;
    }

    /**
     * Add profileDzialalnosci
     *
     * @param ProfilDzialalnosci $profileDzialalnosci
     * @return $this
     */
    public function addProfileDzialalnosci(ProfilDzialalnosci $profileDzialalnosci)
    {
        $this->profileDzialalnosci[] = $profileDzialalnosci;
    
        return $this;
    }

    /**
     * Remove profileDzialalnosci
     *
     * @param ProfilDzialalnosci $profileDzialalnosci
     */
    public function removeProfileDzialalnosci(ProfilDzialalnosci $profileDzialalnosci)
    {
        $this->profileDzialalnosci->removeElement($profileDzialalnosci);
    }

    /**
     * Get profileDzialalnosci
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfileDzialalnosci()
    {
        return $this->profileDzialalnosci;
    }

    /**
     * Add filieProcesyPrzygotowaniaPowierzchni
     *
     * @param FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni
     * @return $this
     */
    public function addFilieProcesyPrzygotowaniaPowierzchni(
        FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni)
    {
        $this->filieProcesyPrzygotowaniaPowierzchni[] = $filieProcesyPrzygotowaniaPowierzchni;
        $filieProcesyPrzygotowaniaPowierzchni->setFilia($this);
        return $this;
    }

    public function addFilieProcesyPrzygotowaniaPowierzchnus(
        FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni)
    {
        $this->filieProcesyPrzygotowaniaPowierzchni[] = $filieProcesyPrzygotowaniaPowierzchni;
        $filieProcesyPrzygotowaniaPowierzchni->setFilia($this);
        return $this;
    }

    /**
     * Remove filieProcesyPrzygotowaniaPowierzchni
     *
     * @param FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni
     */
    public function removeFilieProcesyPrzygotowaniaPowierzchni(
        FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni)
    {
        $this->filieProcesyPrzygotowaniaPowierzchni->removeElement($filieProcesyPrzygotowaniaPowierzchni);
    }

    public function removeFilieProcesyPrzygotowaniaPowierzchnus(
        FiliaProcesPrzygotowaniaPowierzchni $filieProcesyPrzygotowaniaPowierzchni)
    {
        $this->filieProcesyPrzygotowaniaPowierzchni->removeElement($filieProcesyPrzygotowaniaPowierzchni);
    }

    /**
     * Get filieProcesyPrzygotowaniaPowierzchni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieProcesyPrzygotowaniaPowierzchni()
    {
        return $this->filieProcesyPrzygotowaniaPowierzchni;
    }

    /**
     * Add filieProcesyAplikacji
     *
     * @param FiliaProcesAplikacji $filieProcesyAplikacji
     * @return $this
     */
    //TODO należy sprawdzić czemu następuje zmiana nazwy metody poprzez dodanie końcówki 'us'
    public function addFilieProcesyAplikacjus(FiliaProcesAplikacji $filieProcesyAplikacji)
    {
        $this->filieProcesyAplikacji[] = $filieProcesyAplikacji;
        $filieProcesyAplikacji->setFilia($this);
    
        return $this;
    }

    /**
     * Remove filieProcesyAplikacji
     *
     * @param FiliaProcesAplikacji $filieProcesyAplikacji
     */
    public function removeFilieProcesyAplikacjus(FiliaProcesAplikacji $filieProcesyAplikacji)
    {
        $this->filieProcesyAplikacji->removeElement($filieProcesyAplikacji);
    }

    /**
     * Get filieProcesyAplikacji
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieProcesyAplikacji()
    {
        return $this->filieProcesyAplikacji;
    }

    /**
     * Add filieProcesyUtwardzaniaPowlok
     *
     * @param FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok
     * @return $this
     */
    public function addFilieProcesyUtwardzaniaPowlokus(FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok)
    {
        $this->filieProcesyUtwardzaniaPowlok[] = $filieProcesyUtwardzaniaPowlok;
        $filieProcesyUtwardzaniaPowlok->setFilia($this);
    
        return $this;
    }

    /**
     * Remove filieProcesyUtwardzaniaPowlok
     *
     * @param FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok
     */
    public function removeFilieProcesyUtwardzaniaPowlokus(FiliaProcesUtwardzaniaPowloki $filieProcesyUtwardzaniaPowlok)
    {
        $this->filieProcesyUtwardzaniaPowlok->removeElement($filieProcesyUtwardzaniaPowlok);
    }

    /**
     * Get filieProcesyUtwardzaniaPowlok
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieProcesyUtwardzaniaPowloki()
    {
        return $this->filieProcesyUtwardzaniaPowlok;
    }

    /**
     * Add filieWymaganiaProduktow
     *
     * @param FiliaWymaganiaProduktu $filieWymaganiaProduktow
     * @return $this
     */
    public function addFilieWymaganiaProduktu(FiliaWymaganiaProduktu $filieWymaganiaProduktow)
    {
        $this->filieWymaganiaProduktow[] = $filieWymaganiaProduktow;
        $filieWymaganiaProduktow->setFilia($this);
    
        return $this;
    }

    /**
     * Remove filieWymaganiaProduktow
     *
     * @param FiliaWymaganiaProduktu $filieWymaganiaProduktow
     */
    public function removeFilieWymaganiaProduktu(FiliaWymaganiaProduktu $filieWymaganiaProduktow)
    {
        $this->filieWymaganiaProduktow->removeElement($filieWymaganiaProduktow);
    }

    /**
     * Get filieWymaganiaProduktow
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieWymaganiaProduktu()
    {
        return $this->filieWymaganiaProduktow;
    }

    /**
     * Add filieWymaganiaPowlok
     *
     * @param FiliaWymaganiaPowloki $filieWymaganiaPowlok
     * @return $this
     */
    public function addFilieWymaganiaPowlokus(FiliaWymaganiaPowloki $filieWymaganiaPowlok)
    {
        $this->filieWymaganiaPowlok[] = $filieWymaganiaPowlok;
        $filieWymaganiaPowlok->setFilia($this);
    
        return $this;
    }

    /**
     * Remove filieWymaganiaPowlok
     *
     * @param FiliaWymaganiaPowloki $filieWymaganiaPowlok
     */
    public function removeFilieWymaganiaPowlokus(FiliaWymaganiaPowloki $filieWymaganiaPowlok)
    {
        $this->filieWymaganiaPowlok->removeElement($filieWymaganiaPowlok);
    }

    /**
     * Get filieWymaganiaPowlok
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFilieWymaganiaPowloki()
    {
        return $this->filieWymaganiaPowlok;
    }

    /**
     * @return boolean
     * @return bool
     */
    public function getAktywna()
    {
        return $this->aktywna;
    }

    /**
     * @param $aktywna
     * @param boolean $aktywna
     */
    public function setAktywna($aktywna)
    {
        $this->aktywna = $aktywna;
    }

    /**
     * Set adnotacja
     *
     * @param string $adnotacja
     * @return Filia
     */
    public function setAdnotacja($adnotacja)
    {
        $this->adnotacja = $adnotacja;
    
        return $this;
    }

    /**
     * Get adnotacja
     *
     * @return string
     */
    public function getAdnotacja()
    {
        return $this->adnotacja;
    }

    /**
     * Add filieRodzajePowierzchni
     *
     * @param FiliaRodzajPowierzchni $filieRodzajePowierzchni
     * @return Filia
     */
    public function addFilieRodzajePowierzchnus(FiliaRodzajPowierzchni $filieRodzajePowierzchni)
    {
        $this->filieRodzajePowierzchni[] = $filieRodzajePowierzchni;
        $filieRodzajePowierzchni->setFilia($this);

        return $this;
    }

    /**
     * Remove filieRodzajePowierzchni
     *
     * @param FiliaRodzajPowierzchni $filieRodzajePowierzchni
     */
    public function removeFilieRodzajePowierzchnus(FiliaRodzajPowierzchni $filieRodzajePowierzchni)
    {
        $this->filieRodzajePowierzchni->removeElement($filieRodzajePowierzchni);
    }

    /**
     * Get filieRodzajePowierzchni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilieRodzajePowierzchni()
    {
        return $this->filieRodzajePowierzchni;
    }
}