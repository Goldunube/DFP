<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RaportTechniczny
 *
 * @ORM\Table(name="raporty_techniczne")
 * @ORM\Entity(repositoryClass="GCSV\RaportBundle\Entity\RaportTechnicznyRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class RaportTechniczny
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
     * @ORM\Column(name="cel", type="string", length=255, nullable=false)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "2",
     *      max = "255"
     * )
     */
    private $cel;

    /**
     * @var string
     * @ORM\Column(name="col1",type="string",length=255,nullable=true)
     */
    private $tempOtoczenia;

    /**
     * @var string
     * @ORM\Column(name="col2",type="string",length=255,nullable=true)
     */
    private $wilgotnosc;

    /**
     * @var string
     * @ORM\Column(name="col3",type="string",length=255,nullable=true)
     */
    private $tempPodloza;

    /**
     * @var string
     * @ORM\Column(name="col4",type="string",length=255,nullable=true)
     */
    private $punktRosy;

    /**
     * @var string
     * @ORM\Column(name="col5",type="string",length=255,nullable=true)
     */
    private $tempGruntu;

    /**
     * @var string
     * @ORM\Column(name="col6",type="string",length=255,nullable=true)
     */
    private $tempMiedzywarstwy;

    /**
     * @var string
     * @ORM\Column(name="col7",type="string",length=255,nullable=true)
     */
    private $tempFarbyNawierzchniowej;

    /**
     * @var string
     * @ORM\Column(name="col8",type="string",length=255,nullable=true)
     */
    private $roznicaTemperaturPodloza;

    /**
     * @var string
     * @ORM\Column(name="col9",type="string",length=255,nullable=true)
     */
    private $systemMalarski;

    /**
     * @var string
     * @ORM\Column(name="col10",type="string",length=255,nullable=true)
     */
    private $przygotowaniePowierzchni;

    /**
     * @var string
     * @ORM\Column(name="col11",type="string",length=255,nullable=true)
     */
    private $apliHydro;

    /**
     * @var string
     * @ORM\Column(name="col12",type="string",length=255,nullable=true)
     */
    private $apliElektro;

    /**
     * @var string
     * @ORM\Column(name="col13",type="string",length=255,nullable=true)
     */
    private $apliPisto;

    /**
     * @var string
     * @ORM\Column(name="col14",type="string",length=255,nullable=true)
     */
    private $aplikacjaInne;

    /**
     * @var string
     * @ORM\Column(name="col15",type="string",length=255,nullable=true)
     */
    private $rodzajMalowanejPowierzchni;

    /**
     * @var string
     * @ORM\Column(name="col16",type="string",length=255,nullable=true)
     */
    private $rodzajElementu;

    /**
     * @var string
     * @ORM\Column(name="col17",type="string",length=255,nullable=true)
     */
    private $gruboscNaMokro;

    /**
     * @var string
     * @ORM\Column(name="col18",type="string",length=255,nullable=true)
     */
    private $przerwaNaOdparowanie;

    /**
     * @var string
     * @ORM\Column(name="col19",type="string",length=255,nullable=true)
     */
    private $gruboscMiedzywarstwy;

    /**
     * @var string
     * @ORM\Column(name="col20",type="string",length=255,nullable=true)
     */
    private $przerwaNaOdparowanieMiedzywarstwy;

    /**
     * @var string
     * @ORM\Column(name="col21",type="string",length=255,nullable=true)
     */
    private $gruboscNawierzchniNaMokro;

    /**
     * @var string
     * @ORM\Column(name="col22",type="string",length=255,nullable=true)
     */
    private $odparowanie;

    /**
     * @var string
     * @ORM\Column(name="col23",type="string",length=255,nullable=true)
     */
    private $suszenie;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     */
    private $autor;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="data_utworzenia", type="datetime")
     */
    private $dataUtworzenia;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     */
    private $modyfikujacy;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="data_modyfikacji", type="datetime")
     */
    private $dataModyfikacji;

    /**
     * @ORM\ManyToOne(targetEntity="GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne",inversedBy="raportyTechniczne")
     * @ORM\JoinColumn(name="zdarzenie_techniczne_id", nullable=false)
     */
    private $zdarzenieTechniczne;

    /**
     * @var boolean
     * @ORM\Column(name="usuniety", nullable=false, type="boolean")
     */
    private $usuniety = false;

    /**
     * @var int
     *
     * @ORM\Column(name="ile_razy_edytowano", type="integer",nullable=true)
     */
    private $licznikEdycji = 0;

    /**
     * @var array
     *
     * @ORM\Column(name="daty_edycji", type="array",nullable=true)
     */
    private $datyEdycji = array();

    /**
     * @var string
     * @ORM\Column(name="wykonane_prace",type="text", nullable=true)
     */
    private $wykonanePrace;

    /**
     * @var string
     * @ORM\Column(name="wnioski",type="text", nullable=true)
     */
    private $wnioski;


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
     * Set cel
     *
     * @param string $cel
     * @return RaportTechniczny
     */
    public function setCel($cel)
    {
        $this->cel = $cel;

        return $this;
    }

    /**
     * Get cel
     *
     * @return string 
     */
    public function getCel()
    {
        return $this->cel;
    }

    /**
     * Set autor
     *
     * @param string $autor
     * @return RaportTechniczny
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return string 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set dataUtworzenia
     *
     * @param \DateTime $dataUtworzenia
     * @return RaportTechniczny
     */
    public function setDataUtworzenia($dataUtworzenia)
    {
        $this->dataUtworzenia = $dataUtworzenia;

        return $this;
    }

    /**
     * Get dataUtworzenia
     *
     * @return \DateTime 
     */
    public function getDataUtworzenia()
    {
        return $this->dataUtworzenia;
    }

    /**
     * Set modyfikujacy
     *
     * @param string $modyfikujacy
     * @return RaportTechniczny
     */
    public function setModyfikujacy($modyfikujacy)
    {
        $this->modyfikujacy = $modyfikujacy;

        return $this;
    }

    /**
     * Get modyfikujacy
     *
     * @return string 
     */
    public function getModyfikujacy()
    {
        return $this->modyfikujacy;
    }

    /**
     * Set dataModyfikacji
     *
     * @param \DateTime $dataModyfikacji
     * @return RaportTechniczny
     */
    public function setDataModyfikacji($dataModyfikacji)
    {
        $this->dataModyfikacji = $dataModyfikacji;

        return $this;
    }

    /**
     * Get dataModyfikacji
     *
     * @return \DateTime 
     */
    public function getDataModyfikacji()
    {
        return $this->dataModyfikacji;
    }

    /**
     * Set zdarzenieTechniczne
     *
     * @param ZdarzenieTechniczne $zdarzenieTechniczne
     * @return RaportTechniczny
     */
    public function setZdarzenieTechniczne(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $this->zdarzenieTechniczne = $zdarzenieTechniczne;

        return $this;
    }

    /**
     * Get zdarzenieTechniczne
     *
     * @return ZdarzenieTechniczne
     */
    public function getZdarzenieTechniczne()
    {
        return $this->zdarzenieTechniczne;
    }

    /**
     * @return boolean
     */
    public function getUsuniety()
    {
        return $this->usuniety;
    }

    /**
     * @param boolean $usuniety
     */
    public function setUsuniety($usuniety)
    {
        $this->usuniety = $usuniety;
    }

    /**
     * @return int
     */
    public function getLicznikEdycji()
    {
        return $this->licznikEdycji;
    }

    /**
     * @param int $licznikEdycji
     */
    public function setLicznikEdycji($licznikEdycji)
    {
        $this->licznikEdycji = $licznikEdycji;
    }

    /**
     * @return array
     */
    public function getDatyEdycji()
    {
        $daty = array();
        foreach ($this->datyEdycji as $dataEdycji)
        {
            array_push($daty,$dataEdycji->format('Y-m-d H:i:s'));
        }

        return $daty;
    }

    /**
     * @param array $datyEdycji
     */
    public function setDatyEdycji($datyEdycji)
    {
        $this->datyEdycji = $datyEdycji;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setDataEdycjiOrazLicznik()
    {
        $this->licznikEdycji++;
        if(!is_array($this->datyEdycji))
        {
            $this->datyEdycji = array();
        }
        array_push($this->datyEdycji,new \DateTime());
    }

    /**
     * Set tempOtoczenia
     *
     * @param string $tempOtoczenia
     *
     * @return RaportTechniczny
     */
    public function setTempOtoczenia($tempOtoczenia)
    {
        $this->tempOtoczenia = $tempOtoczenia;

        return $this;
    }

    /**
     * Get tempOtoczenia
     *
     * @return string
     */
    public function getTempOtoczenia()
    {
        return $this->tempOtoczenia;
    }

    /**
     * Set wilgotnosc
     *
     * @param string $wilgotnosc
     *
     * @return RaportTechniczny
     */
    public function setWilgotnosc($wilgotnosc)
    {
        $this->wilgotnosc = $wilgotnosc;

        return $this;
    }

    /**
     * Get wilgotnosc
     *
     * @return string
     */
    public function getWilgotnosc()
    {
        return $this->wilgotnosc;
    }

    /**
     * Set tempPodloza
     *
     * @param string $tempPodloza
     *
     * @return RaportTechniczny
     */
    public function setTempPodloza($tempPodloza)
    {
        $this->tempPodloza = $tempPodloza;

        return $this;
    }

    /**
     * Get tempPodloza
     *
     * @return string
     */
    public function getTempPodloza()
    {
        return $this->tempPodloza;
    }

    /**
     * Set punktRosy
     *
     * @param string $punktRosy
     *
     * @return RaportTechniczny
     */
    public function setPunktRosy($punktRosy)
    {
        $this->punktRosy = $punktRosy;

        return $this;
    }

    /**
     * Get punktRosy
     *
     * @return string
     */
    public function getPunktRosy()
    {
        return $this->punktRosy;
    }

    /**
     * Set tempGruntu
     *
     * @param string $tempGruntu
     *
     * @return RaportTechniczny
     */
    public function setTempGruntu($tempGruntu)
    {
        $this->tempGruntu = $tempGruntu;

        return $this;
    }

    /**
     * Get tempGruntu
     *
     * @return string
     */
    public function getTempGruntu()
    {
        return $this->tempGruntu;
    }

    /**
     * Set tempMiedzywarstwy
     *
     * @param string $tempMiedzywarstwy
     *
     * @return RaportTechniczny
     */
    public function setTempMiedzywarstwy($tempMiedzywarstwy)
    {
        $this->tempMiedzywarstwy = $tempMiedzywarstwy;

        return $this;
    }

    /**
     * Get tempMiedzywarstwy
     *
     * @return string
     */
    public function getTempMiedzywarstwy()
    {
        return $this->tempMiedzywarstwy;
    }

    /**
     * Set tempFarbyNawierzchniowej
     *
     * @param string $tempFarbyNawierzchniowej
     *
     * @return RaportTechniczny
     */
    public function setTempFarbyNawierzchniowej($tempFarbyNawierzchniowej)
    {
        $this->tempFarbyNawierzchniowej = $tempFarbyNawierzchniowej;

        return $this;
    }

    /**
     * Get tempFarbyNawierzchniowej
     *
     * @return string
     */
    public function getTempFarbyNawierzchniowej()
    {
        return $this->tempFarbyNawierzchniowej;
    }

    /**
     * Set roznicaTemperaturPodloza
     *
     * @param string $roznicaTemperaturPodloza
     *
     * @return RaportTechniczny
     */
    public function setRoznicaTemperaturPodloza($roznicaTemperaturPodloza)
    {
        $this->roznicaTemperaturPodloza = $roznicaTemperaturPodloza;

        return $this;
    }

    /**
     * Get roznicaTemperaturPodloza
     *
     * @return string
     */
    public function getRoznicaTemperaturPodloza()
    {
        return $this->roznicaTemperaturPodloza;
    }

    /**
     * Set systemMalarski
     *
     * @param string $systemMalarski
     *
     * @return RaportTechniczny
     */
    public function setSystemMalarski($systemMalarski)
    {
        $this->systemMalarski = $systemMalarski;

        return $this;
    }

    /**
     * Get systemMalarski
     *
     * @return string
     */
    public function getSystemMalarski()
    {
        return $this->systemMalarski;
    }

    /**
     * Set przygotowaniePowierzchni
     *
     * @param string $przygotowaniePowierzchni
     *
     * @return RaportTechniczny
     */
    public function setPrzygotowaniePowierzchni($przygotowaniePowierzchni)
    {
        $this->przygotowaniePowierzchni = $przygotowaniePowierzchni;

        return $this;
    }

    /**
     * Get przygotowaniePowierzchni
     *
     * @return string
     */
    public function getPrzygotowaniePowierzchni()
    {
        return $this->przygotowaniePowierzchni;
    }

    /**
     * Set apliHydro
     *
     * @param string $apliHydro
     *
     * @return RaportTechniczny
     */
    public function setApliHydro($apliHydro)
    {
        $this->apliHydro = $apliHydro;

        return $this;
    }

    /**
     * Get apliHydro
     *
     * @return string
     */
    public function getApliHydro()
    {
        return $this->apliHydro;
    }

    /**
     * Set apliElektro
     *
     * @param string $apliElektro
     *
     * @return RaportTechniczny
     */
    public function setApliElektro($apliElektro)
    {
        $this->apliElektro = $apliElektro;

        return $this;
    }

    /**
     * Get apliElektro
     *
     * @return string
     */
    public function getApliElektro()
    {
        return $this->apliElektro;
    }

    /**
     * Set apliPisto
     *
     * @param string $apliPisto
     *
     * @return RaportTechniczny
     */
    public function setApliPisto($apliPisto)
    {
        $this->apliPisto = $apliPisto;

        return $this;
    }

    /**
     * Get apliPisto
     *
     * @return string
     */
    public function getApliPisto()
    {
        return $this->apliPisto;
    }

    /**
     * Set aplikacjaInne
     *
     * @param string $aplikacjaInne
     *
     * @return RaportTechniczny
     */
    public function setAplikacjaInne($aplikacjaInne)
    {
        $this->aplikacjaInne = $aplikacjaInne;

        return $this;
    }

    /**
     * Get aplikacjaInne
     *
     * @return string
     */
    public function getAplikacjaInne()
    {
        return $this->aplikacjaInne;
    }

    /**
     * Set rodzajMalowanejPowierzchni
     *
     * @param string $rodzajMalowanejPowierzchni
     *
     * @return RaportTechniczny
     */
    public function setRodzajMalowanejPowierzchni($rodzajMalowanejPowierzchni)
    {
        $this->rodzajMalowanejPowierzchni = $rodzajMalowanejPowierzchni;

        return $this;
    }

    /**
     * Get rodzajMalowanejPowierzchni
     *
     * @return string
     */
    public function getRodzajMalowanejPowierzchni()
    {
        return $this->rodzajMalowanejPowierzchni;
    }

    /**
     * Set rodzajElementu
     *
     * @param string $rodzajElementu
     *
     * @return RaportTechniczny
     */
    public function setRodzajElementu($rodzajElementu)
    {
        $this->rodzajElementu = $rodzajElementu;

        return $this;
    }

    /**
     * Get rodzajElementu
     *
     * @return string
     */
    public function getRodzajElementu()
    {
        return $this->rodzajElementu;
    }

    /**
     * Set gruboscNaMokro
     *
     * @param string $gruboscNaMokro
     *
     * @return RaportTechniczny
     */
    public function setGruboscNaMokro($gruboscNaMokro)
    {
        $this->gruboscNaMokro = $gruboscNaMokro;

        return $this;
    }

    /**
     * Get gruboscNaMokro
     *
     * @return string
     */
    public function getGruboscNaMokro()
    {
        return $this->gruboscNaMokro;
    }

    /**
     * Set przerwaNaOdparowanie
     *
     * @param string $przerwaNaOdparowanie
     *
     * @return RaportTechniczny
     */
    public function setPrzerwaNaOdparowanie($przerwaNaOdparowanie)
    {
        $this->przerwaNaOdparowanie = $przerwaNaOdparowanie;

        return $this;
    }

    /**
     * Get przerwaNaOdparowanie
     *
     * @return string
     */
    public function getPrzerwaNaOdparowanie()
    {
        return $this->przerwaNaOdparowanie;
    }

    /**
     * Set gruboscMiedzywarstwy
     *
     * @param string $gruboscMiedzywarstwy
     *
     * @return RaportTechniczny
     */
    public function setGruboscMiedzywarstwy($gruboscMiedzywarstwy)
    {
        $this->gruboscMiedzywarstwy = $gruboscMiedzywarstwy;

        return $this;
    }

    /**
     * Get gruboscMiedzywarstwy
     *
     * @return string
     */
    public function getGruboscMiedzywarstwy()
    {
        return $this->gruboscMiedzywarstwy;
    }

    /**
     * Set przerwaNaOdparowanieMiedzywarstwy
     *
     * @param string $przerwaNaOdparowanieMiedzywarstwy
     *
     * @return RaportTechniczny
     */
    public function setPrzerwaNaOdparowanieMiedzywarstwy($przerwaNaOdparowanieMiedzywarstwy)
    {
        $this->przerwaNaOdparowanieMiedzywarstwy = $przerwaNaOdparowanieMiedzywarstwy;

        return $this;
    }

    /**
     * Get przerwaNaOdparowanieMiedzywarstwy
     *
     * @return string
     */
    public function getPrzerwaNaOdparowanieMiedzywarstwy()
    {
        return $this->przerwaNaOdparowanieMiedzywarstwy;
    }

    /**
     * Set gruboscNawierzchniNaMokro
     *
     * @param string $gruboscNawierzchniNaMokro
     *
     * @return RaportTechniczny
     */
    public function setGruboscNawierzchniNaMokro($gruboscNawierzchniNaMokro)
    {
        $this->gruboscNawierzchniNaMokro = $gruboscNawierzchniNaMokro;

        return $this;
    }

    /**
     * Get gruboscNawierzchniNaMokro
     *
     * @return string
     */
    public function getGruboscNawierzchniNaMokro()
    {
        return $this->gruboscNawierzchniNaMokro;
    }

    /**
     * Set odparowanie
     *
     * @param string $odparowanie
     *
     * @return RaportTechniczny
     */
    public function setOdparowanie($odparowanie)
    {
        $this->odparowanie = $odparowanie;

        return $this;
    }

    /**
     * Get odparowanie
     *
     * @return string
     */
    public function getOdparowanie()
    {
        return $this->odparowanie;
    }

    /**
     * Set suszenie
     *
     * @param string $suszenie
     *
     * @return RaportTechniczny
     */
    public function setSuszenie($suszenie)
    {
        $this->suszenie = $suszenie;

        return $this;
    }

    /**
     * Get suszenie
     *
     * @return string
     */
    public function getSuszenie()
    {
        return $this->suszenie;
    }

    /**
     * @param string $wykonanePrace
     */
    public function setWykonanePrace($wykonanePrace)
    {
        $this->wykonanePrace = $wykonanePrace;
    }

    /**
     * @return string
     */
    public function getWykonanePrace()
    {
        return $this->wykonanePrace;
    }

    /**
     * @param string $wnioski
     */
    public function setWnioski($wnioski)
    {
        $this->wnioski = $wnioski;
    }

    /**
     * @return string
     */
    public function getWnioski()
    {
        return $this->wnioski;
    }

}
