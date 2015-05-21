<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Produkt
 *
 * @ORM\Table(name="produkty")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProduktRepository")
 */
class Produkt
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
     * @ORM\Column(name="nazwa_handlowa", type="string", length=255)
     */
    private $nazwaHandlowa;

    /**
     * Nazwa techniczna produktu
     *
     * @var string
     * @ORM\Column(name="nazwa_techniczna", type="string", length=255, nullable=true)
     */
    private $nazwaTechniczna;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", nullable=true)
     */
    private $uwagi;

    /**
     * Parametr określający przynależność produktu do grupy promowania. Grupa promowania determinuje kolejność wyświetlania produktu.
     *
     * @var integer
     *
     * @ORM\Column(name="grupa_promowania", type="integer")
     */
    private $grupaPromowania = 0;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\GrupaProduktow", inversedBy="produkty", cascade={"persist"})
     */
    private $grupaProduktow;

    /**
     * Numer edycji karty technicznej
     *
     * @var integer
     * @ORM\Column(name="numer_edycji", type="integer", nullable=true)
     */
    private $numerEdycji;

    /**
     * Numer edycji karty technicznej BESA
     *
     * @var string
     * @ORM\Column(name="numer_edycji_besa", type="string", length=255, nullable=true)
     */
    private $numerEdycjiBESA;

    /**
     * Numer edycji karty technicznej CSV
     *
     * @var string
     * @ORM\Column(name="numer_edycji_csv", type="string", length=255, nullable=true)
     */
    private $numerEdycjiCSV;

    /**
     * Kod farbryczny produktu nadawany przez producenta
     *
     * @var string
     * @ORM\Column(name="kod_fabryczny", type="string", nullable=true)
     */
    private $kodFabrycznyProduktu;

    /**
     * Podstawowy opis zastosowania produktu
     *
     * @var string
     * @ORM\Column(name="opis_podstawowy", type="text", nullable=true)
     */
    private $opisPodstawowy;

    /**
     * Pełny opis zastosowania produktu
     *
     * @var string
     * @ORM\Column(name="opis_pelny", type="text", nullable=true)
     */
    private $opisPelny;

    /**
     * Grupa cech technicznych produktu
     *
     * @ORM\OneToOne(targetEntity="CechyTechniczneProduktu", cascade={"persist"})
     * @Assert\Valid()
     */
    private $cechyTechniczneProduktu;

    /**
     * Zgodność produktu z normami
     *
     * @ORM\Column(name="zgodnosc_norm", type="array", nullable=true)
     */
    private $zgodnoscNorm;

    /**
     * Grupa danych technicznych produktu
     *
     * @ORM\OneToOne(targetEntity="DaneTechniczneProduktu", cascade={"persist"})
     * @Assert\Valid()
     */
    private $daneTechniczne;

    /**
     * @ORM\ManyToMany(targetEntity="RodzajPowierzchni")
     */
    private $rodzajePowierzchni;

    /**
     * @ORM\ManyToMany(targetEntity="ProcesPrzygotowaniaPowierzchni")
     */
    private $przygotowaniePowierzchni;

    /**
     * @var string
     *
     * @ORM\Column(name="przygotowanie_powierzchni_uwagi", type="text", nullable=true)
     */
    private $przygotowaniePowierzchniUwagi;

    /**
     * @ORM\ManyToMany(targetEntity="ProcesAplikacji")
     */
    private $metodyAplikacji;

    /**
     * @ORM\OneToOne(targetEntity="PrzygotowanieDoAplikacji", cascade={"persist"})
     * @Assert\Valid()
     */
    private $przygotowanieDoAplikacji;

    /**
     * @ORM\OneToOne(targetEntity="SuszenieProdukt", cascade={"persist"})
     * @Assert\Valid()
     */
    private $suszenie;

    /**
     * @ORM\OneToOne(targetEntity="CharakterystykaProduktu", cascade={"persist"})
     * @Assert\Valid()
     */
    private $charakterystykaProduktu;

    /**
     * Czas magazynowania wyrażony w miesiacach
     *
     * @var integer
     * @ORM\Column(name="magazynowanie", type="integer", nullable=true)
     */
    private $czasMagazynowania;

    /**
     * Opis sposobu magazynowania produktu
     *
     * @var string
     * @ORM\Column(name="magazynowanie_opis", type="text", nullable=true)
     */
    private $magazynowanieOpis;

    /**
     * @var array
     * @ORM\Column(name="certyfikaty", type="array", nullable=true)
     */
    private $certyfikaty;

    /**
     * @var array
     * @ORM\Column(name="badania", type="array", nullable=true)
     */
    private $badania;

    /**
     * @ORM\OneToMany(targetEntity="ProduktUtwardzacz", mappedBy="utwardzacz")
     */
    private $produktyUtwardzacze;

    /**
     * @ORM\OneToMany(targetEntity="ProduktRozcienczalnik", mappedBy="rozcienczalnik")
     */
    private $produktyRozcienczalniki;

    /**
     * @var integer
     * @ORM\Column(name="producent", type="integer", nullable=true)
     */
    private $producent = 0;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="DFP\EtapIBundle\Entity\ProduktNotatka", mappedBy="produkt", cascade={"persist"}, orphanRemoval=true)
     * @Assert\Valid()
     * @ORM\OrderBy({"createDate" = "DESC"})
     */
    private $notatki;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->rodzajePowierzchni = new ArrayCollection();
        $this->przygotowaniePowierzchni = new ArrayCollection();
        $this->metodyAplikacji = new ArrayCollection();
        $this->produktyUtwardzacze = new ArrayCollection();
        $this->produktyRozcienczalniki = new ArrayCollection();
        $this->notatki = new ArrayCollection();
    }

    /**
     * To String
     */
    public function __toString()
    {
        return (string) $this->getNazwaHandlowa();
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
     * Set Nazwa Handlowa
     *
     * @param string $nazwaHandlowa
     * @return Produkt
     */
    public function setNazwaHandlowa($nazwaHandlowa)
    {
        $this->nazwaHandlowa = $nazwaHandlowa;
    
        return $this;
    }

    /**
     * Get Nazwa Handlowa
     *
     * @return string 
     */
    public function getNazwaHandlowa()
    {
        return $this->nazwaHandlowa;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     * @return Produkt
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;
    
        return $this;
    }

    /**
     * Get uwagi
     *
     * @return string 
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }

    /**
     * Set Grupa Promowania
     *
     * @param integer $grupaPromowania
     * @return Produkt
     */
    public function setGrupaPromowania($grupaPromowania = 0)
    {
        $this->grupaPromowania = $grupaPromowania;

        return $this;
    }

    /**
     * Get Grupa Promowania
     *
     * @return string
     */
    public function getGrupaPromowania()
    {
        return $this->grupaPromowania;
    }

    /**
     * Set grupaProduktow
     *
     * @param GrupaProduktow $grupaProduktow
     * @return Produkt
     */
    public function setGrupaProduktow(GrupaProduktow $grupaProduktow = null)
    {
        $this->grupaProduktow = $grupaProduktow;

        return $this;
    }

    /**
     * Get grupaProduktow
     *
     * @return GrupaProduktow
     */
    public function getGrupaProduktow()
    {
        return $this->grupaProduktow;
    }

    /**
     * Set nazwaTechniczna
     *
     * @param string $nazwaTechniczna
     * @return Produkt
     */
    public function setNazwaTechniczna($nazwaTechniczna)
    {
        $this->nazwaTechniczna = $nazwaTechniczna;

        return $this;
    }

    /**
     * Get nazwaTechniczna
     *
     * @return string 
     */
    public function getNazwaTechniczna()
    {
        return $this->nazwaTechniczna;
    }

    /**
     * Set numerEdycji
     *
     * @param integer $numerEdycji
     * @return Produkt
     */
    public function setNumerEdycji($numerEdycji)
    {
        $this->numerEdycji = $numerEdycji;

        return $this;
    }

    /**
     * Get numerEdycji
     *
     * @return integer 
     */
    public function getNumerEdycji()
    {
        return $this->numerEdycji;
    }

    /**
     * Set kodFabrycznyProduktu
     *
     * @param integer $kodFabrycznyProduktu
     * @return Produkt
     */
    public function setKodFabrycznyProduktu($kodFabrycznyProduktu)
    {
        $this->kodFabrycznyProduktu = $kodFabrycznyProduktu;

        return $this;
    }

    /**
     * Get kodFabrycznyProduktu
     *
     * @return integer 
     */
    public function getKodFabrycznyProduktu()
    {
        return $this->kodFabrycznyProduktu;
    }

    /**
     * Set opisPodstawowy
     *
     * @param string $opisPodstawowy
     * @return Produkt
     */
    public function setOpisPodstawowy($opisPodstawowy)
    {
        $this->opisPodstawowy = $opisPodstawowy;

        return $this;
    }

    /**
     * Get opisPodstawowy
     *
     * @return string 
     */
    public function getOpisPodstawowy()
    {
        return $this->opisPodstawowy;
    }

    /**
     * Set opisPelny
     *
     * @param string $opisPelny
     * @return Produkt
     */
    public function setOpisPelny($opisPelny)
    {
        $this->opisPelny = $opisPelny;

        return $this;
    }

    /**
     * Get opisPelny
     *
     * @return string 
     */
    public function getOpisPelny()
    {
        return $this->opisPelny;
    }

    /**
     * Set zgodnoscNorm
     *
     * @param array $zgodnoscNorm
     * @return Produkt
     */
    public function setZgodnoscNorm($zgodnoscNorm)
    {
        $this->zgodnoscNorm = $zgodnoscNorm;

        return $this;
    }

    /**
     * Get zgodnoscNorm
     *
     * @return array 
     */
    public function getZgodnoscNorm()
    {
        return $this->zgodnoscNorm;
    }

    /**
     * Set czasMagazynowania
     *
     * @param integer $czasMagazynowania
     * @param $jednostka
     * @return Produkt
     */
    public function setCzasMagazynowania($czasMagazynowania, $jednostka = 0)
    {
        if($jednostka == 1)
        {
            $czasMagazynowania = $czasMagazynowania * 12;
            $this->czasMagazynowania = round($czasMagazynowania);
        }else{
            $this->czasMagazynowania = round($czasMagazynowania);
        }

        return $this;
    }

    /**
     * Get czasMagazynowania
     *
     * @return integer 
     */
    public function getCzasMagazynowania()
    {
        return $this->czasMagazynowania;
    }

    /**
     * Set certyfikaty
     *
     * @param array $certyfikaty
     * @return Produkt
     */
    public function setCertyfikaty($certyfikaty)
    {
        $this->certyfikaty = $certyfikaty;

        return $this;
    }

    /**
     * Get certyfikaty
     *
     * @return array 
     */
    public function getCertyfikaty()
    {
        return $this->certyfikaty;
    }

    /**
     * Set badania
     *
     * @param array $badania
     * @return Produkt
     */
    public function setBadania($badania)
    {
        $this->badania = $badania;

        return $this;
    }

    /**
     * Get badania
     *
     * @return array 
     */
    public function getBadania()
    {
        return $this->badania;
    }

    /**
     * Set cechyTechniczneProduktu
     *
     * @param CechyTechniczneProduktu $cechyTechniczneProduktu
     * @return Produkt
     */
    public function setCechyTechniczneProduktu(CechyTechniczneProduktu $cechyTechniczneProduktu = null)
    {
        $this->cechyTechniczneProduktu = $cechyTechniczneProduktu;

        return $this;
    }

    /**
     * Get cechyTechniczneProduktu
     *
     * @return CechyTechniczneProduktu
     */
    public function getCechyTechniczneProduktu()
    {
        return $this->cechyTechniczneProduktu;
    }

    /**
     * Set daneTechniczne
     *
     * @param DaneTechniczneProduktu $daneTechniczne
     * @return Produkt
     */
    public function setDaneTechniczne(DaneTechniczneProduktu $daneTechniczne = null)
    {
        $this->daneTechniczne = $daneTechniczne;

        return $this;
    }

    /**
     * Get daneTechniczne
     *
     * @return DaneTechniczneProduktu
     */
    public function getDaneTechniczne()
    {
        return $this->daneTechniczne;
    }

    /**
     * Add rodzajePowierzchni
     *
     * @param RodzajPowierzchni $rodzajePowierzchni
     * @return Produkt
     */
    public function addRodzajePowierzchni(RodzajPowierzchni $rodzajePowierzchni)
    {
        $this->rodzajePowierzchni[] = $rodzajePowierzchni;

        return $this;
    }

    /**
     * Remove rodzajePowierzchni
     *
     * @param RodzajPowierzchni $rodzajePowierzchni
     */
    public function removeRodzajePowierzchni(RodzajPowierzchni $rodzajePowierzchni)
    {
        $this->rodzajePowierzchni->removeElement($rodzajePowierzchni);
    }

    /**
     * Get rodzajePowierzchni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRodzajePowierzchni()
    {
        return $this->rodzajePowierzchni;
    }

    /**
     * Add przygotowaniePowierzchni
     *
     * @param ProcesPrzygotowaniaPowierzchni $przygotowaniePowierzchni
     * @return Produkt
     */
    public function addPrzygotowaniePowierzchni(ProcesPrzygotowaniaPowierzchni $przygotowaniePowierzchni)
    {
        $this->przygotowaniePowierzchni[] = $przygotowaniePowierzchni;

        return $this;
    }

    /**
     * Remove przygotowaniePowierzchni
     *
     * @param ProcesPrzygotowaniaPowierzchni $przygotowaniePowierzchni
     */
    public function removePrzygotowaniePowierzchni(ProcesPrzygotowaniaPowierzchni $przygotowaniePowierzchni)
    {
        $this->przygotowaniePowierzchni->removeElement($przygotowaniePowierzchni);
    }

    /**
     * Get przygotowaniePowierzchni
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPrzygotowaniePowierzchni()
    {
        return $this->przygotowaniePowierzchni;
    }

    /**
     * Add metodyAplikacji
     *
     * @param ProcesAplikacji $metodyAplikacji
     * @return Produkt
     */
    public function addMetodyAplikacji(ProcesAplikacji $metodyAplikacji)
    {
        $this->metodyAplikacji[] = $metodyAplikacji;

        return $this;
    }

    /**
     * Remove metodyAplikacji
     *
     * @param ProcesAplikacji $metodyAplikacji
     */
    public function removeMetodyAplikacji(ProcesAplikacji $metodyAplikacji)
    {
        $this->metodyAplikacji->removeElement($metodyAplikacji);
    }

    /**
     * Get metodyAplikacji
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMetodyAplikacji()
    {
        return $this->metodyAplikacji;
    }

    /**
     * Set przygotowanieDoAplikacji
     *
     * @param PrzygotowanieDoAplikacji $przygotowanieDoAplikacji
     * @return Produkt
     */
    public function setPrzygotowanieDoAplikacji(PrzygotowanieDoAplikacji $przygotowanieDoAplikacji = null)
    {
        $this->przygotowanieDoAplikacji = $przygotowanieDoAplikacji;

        return $this;
    }

    /**
     * Get przygotowanieDoAplikacji
     *
     * @return PrzygotowanieDoAplikacji
     */
    public function getPrzygotowanieDoAplikacji()
    {
        return $this->przygotowanieDoAplikacji;
    }

    /**
     * Set suszenie
     *
     * @param SuszenieProdukt $suszenie
     * @return Produkt
     */
    public function setSuszenie(SuszenieProdukt $suszenie = null)
    {
        $this->suszenie = $suszenie;

        return $this;
    }

    /**
     * Get suszenie
     *
     * @return SuszenieProdukt
     */
    public function getSuszenie()
    {
        return $this->suszenie;
    }

    /**
     * Set charakterystykaProduktu
     *
     * @param CharakterystykaProduktu $charakterystykaProduktu
     * @return Produkt
     */
    public function setCharakterystykaProduktu(CharakterystykaProduktu $charakterystykaProduktu = null)
    {
        $this->charakterystykaProduktu = $charakterystykaProduktu;

        return $this;
    }

    /**
     * Get charakterystykaProduktu
     *
     * @return CharakterystykaProduktu
     */
    public function getCharakterystykaProduktu()
    {
        return $this->charakterystykaProduktu;
    }

    /**
     * Add produktyUtwardzacze
     *
     * @param ProduktUtwardzacz $produktyUtwardzacze
     * @return Produkt
     */
    public function addProduktyUtwardzacze(ProduktUtwardzacz $produktyUtwardzacze)
    {
        $this->produktyUtwardzacze[] = $produktyUtwardzacze;

        return $this;
    }

    /**
     * Remove produktyUtwardzacze
     *
     * @param ProduktUtwardzacz $produktyUtwardzacze
     */
    public function removeProduktyUtwardzacze(ProduktUtwardzacz $produktyUtwardzacze)
    {
        $this->produktyUtwardzacze->removeElement($produktyUtwardzacze);
    }

    /**
     * Get produktyUtwardzacze
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduktyUtwardzacze()
    {
        return $this->produktyUtwardzacze;
    }

    /**
     * Add produktyRozcienczalniki
     *
     * @param ProduktRozcienczalnik $produktyRozcienczalniki
     * @return Produkt
     */
    public function addProduktyRozcienczalniki(ProduktRozcienczalnik $produktyRozcienczalniki)
    {
        $this->produktyRozcienczalniki[] = $produktyRozcienczalniki;

        return $this;
    }

    /**
     * Remove produktyRozcienczalniki
     *
     * @param ProduktRozcienczalnik $produktyRozcienczalniki
     */
    public function removeProduktyRozcienczalniki(ProduktRozcienczalnik $produktyRozcienczalniki)
    {
        $this->produktyRozcienczalniki->removeElement($produktyRozcienczalniki);
    }

    /**
     * Get produktyRozcienczalniki
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduktyRozcienczalniki()
    {
        return $this->produktyRozcienczalniki;
    }

    /**
     * @return string
     */
    public function getNumerEdycjiBESA()
    {
        return $this->numerEdycjiBESA;
    }

    /**
     * @param string $numerEdycjiBESA
     */
    public function setNumerEdycjiBESA($numerEdycjiBESA)
    {
        $this->numerEdycjiBESA = $numerEdycjiBESA;
    }

    /**
     * @return string
     */
    public function getMagazynowanieOpis()
    {
        return $this->magazynowanieOpis;
    }

    /**
     * @param string $magazynowanieOpis
     */
    public function setMagazynowanieOpis($magazynowanieOpis)
    {
        $this->magazynowanieOpis = $magazynowanieOpis;
    }

    /**
     * @return string
     */
    public function getNumerEdycjiCSV()
    {
        return $this->numerEdycjiCSV;
    }

    /**
     * @param string $numerEdycjiCSV
     */
    public function setNumerEdycjiCSV($numerEdycjiCSV)
    {
        $this->numerEdycjiCSV = $numerEdycjiCSV;
    }

    /**
     * @return string
     */
    public function getPrzygotowaniePowierzchniUwagi()
    {
        return $this->przygotowaniePowierzchniUwagi;
    }

    /**
     * @param string $przygotowaniePowierzchniUwagi
     */
    public function setPrzygotowaniePowierzchniUwagi($przygotowaniePowierzchniUwagi)
    {
        $this->przygotowaniePowierzchniUwagi = $przygotowaniePowierzchniUwagi;
    }

    /**
     * @return int
     */
    public function getProducent()
    {
        return $this->producent;
    }

    /**
     * @param int $producent
     */
    public function setProducent($producent)
    {
        $this->producent = $producent;
    }

    /**
     * Add notatki
     *
     * @param ProduktNotatka $notatki
     * @return Produkt
     */
    public function addNotatki(ProduktNotatka $notatki)
    {
        $this->notatki[] = $notatki;

        return $this;
    }

    /**
     * Remove notatki
     *
     * @param ProduktNotatka $notatki
     */
    public function removeNotatki(ProduktNotatka $notatki)
    {
        $this->notatki->removeElement($notatki);
    }

    /**
     * Get notatki
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotatki()
    {
        return $this->notatki;
    }
}
