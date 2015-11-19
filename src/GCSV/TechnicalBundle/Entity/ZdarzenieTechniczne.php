<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use DFP\EtapIBundle\Entity\Filia as Oddzial;
use GCSV\RaportBundle\Entity\Notatka;
//use GCSV\RecepturaBundle\Entity\Receptura;
use DFP\EtapIBundle\Entity\Uzytkownik;
use GCSV\RaportBundle\Entity\RaportTechniczny;
use GCSV\RaportBundle\Entity\RaportZuzycia;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ZdarzenieTechniczne
 *
 * @ORM\Table(name="zdarzenia_techniczne")
 * @ORM\Entity(repositoryClass="GCSV\TechnicalBundle\Entity\ZdarzenieTechniczneRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ZdarzenieTechniczne
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
     * @ORM\ManyToOne(targetEntity="RodzajZdarzeniaTechnicznego", inversedBy="zdarzeniaTechniczne")
     * @ORM\JoinColumn(name="rodzaj_zdarzenia_id" ,nullable=false)
     * @Assert\NotBlank()
     */
    private $rodzajZdarzeniaTechnicznego;

    /**
     * @var integer
     *
     * @ORM\Column(name="stopien_realizacji", type="integer")
     */
    private $stopienRealizacji = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="priorytet", type="integer")
     */
    private $priorytet = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="dlugosc_geo", type="decimal", scale=12, precision=18, nullable=true)
     */
    private $dlugoscGeo;

    /**
     * @var string
     *
     * @ORM\Column(name="szerokosc_geo", type="decimal", scale=12, precision=18, nullable=true)
     */
    private $szerokoscGeo;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="osoba_zlecajaca_id", nullable=false)
     * @ORM\OrderBy({"imie","ASC"})
     * @Assert\NotBlank()
     */
    private $osobaZlecajaca;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="osoba_wprowadzajaca_id", nullable=false)
     */
    private $osobaWprowadzajaca;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="data_wprowadzenia", type="datetime")
     */
    private $dataWprowadzenia;

    /**
     * @Gedmo\Blameable(on="update", field={"dlugoscGeo", "szerokoscGeo", "priorytet", "rodzajZdarzeniaTechnicznego", "oddzialFirmy", "opis", "status", "uczestnikZdarzeniaTechnicznego.osoba", "uczestnikZdarzeniaTechnicznego.terminy", "uczestnikZdarzeniaTechnicznego.terminy.rozpoczecieWizyty", "uczestnikZdarzeniaTechnicznego.terminy.zakonczenieWizyty"})
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="osoba_modyfikujaca_id", nullable=false)
     */
    private $osobaModyfikujaca;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="data_modyfikacji", type="datetime")
     */
    private $dataModyfikacji;

    /**
     * @ORM\OneToMany(targetEntity="UczestnikZdarzeniaTechnicznego", mappedBy="zdarzenieTechniczne", cascade={"persist"}, orphanRemoval=true)
     * @Assert\NotBlank()
     */
    private $uczestnikZdarzeniaTechnicznego;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Filia", inversedBy="zdarzeniaTechniczne")
     * @ORM\JoinColumn(name="oddzial_firmy")
     */
    private $oddzialFirmy;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text", nullable=true)
     * @Assert\NotBlank()
     */
    private $opis;

    /**
     * @ORM\ManyToOne(targetEntity="StatusZdarzeniaTechnicznego")
     * @ORM\JoinColumn(name="status", nullable=false)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\RaportBundle\Entity\RaportTechniczny", mappedBy="zdarzenieTechniczne",orphanRemoval=true)
     */
    private $raportyTechniczne;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\RaportBundle\Entity\Notatka", mappedBy="zdarzenieTechniczne", orphanRemoval=true)
     */
    private $notatki;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\RaportBundle\Entity\RaportZuzycia", mappedBy="zdarzenieTechniczne")
     */
    private $raportyZuzyc;

    /**
     * @var string
     * @ORM\Column(name="dane_kontaktowe",length=255,nullable=true)
     */
    private $daneKontaktowe;

    /**
     * @var string
     * @ORM\Column(name="produkty",type="text",nullable=true)
     */
    private $produkty;

    /**
     * @var string
     * @ORM\Column(name="elementy_do_lakierowania",type="text",nullable=true)
     */
    private $elementyDoLakierowania;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->uczestnikZdarzeniaTechnicznego = new ArrayCollection();
        $this->raportyTechniczne = new ArrayCollection();
        $this->raportyZuzyc = new ArrayCollection();
        $this->receptury = new ArrayCollection();
        $this->notatki = new ArrayCollection();
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
     * Set stopienRealizacji
     *
     * @param integer $stopienRealizacji
     * @return ZdarzenieTechniczne
     */
    public function setStopienRealizacji($stopienRealizacji)
    {
        $this->stopienRealizacji = $stopienRealizacji;

        return $this;
    }

    /**
     * Get stopienRealizacji
     *
     * @return integer 
     */
    public function getStopienRealizacji()
    {
        return $this->stopienRealizacji;
    }

    /**
     * Set priorytet
     *
     * @param integer $priorytet
     * @return ZdarzenieTechniczne
     */
    public function setPriorytet($priorytet)
    {
        $this->priorytet = $priorytet;

        return $this;
    }

    /**
     * Get priorytet
     *
     * @return integer 
     */
    public function getPriorytet()
    {
        return $this->priorytet;
    }

    /**
     * @return mixed
     */
    public function getOsobaZlecajaca()
    {
        return $this->osobaZlecajaca;
    }

    /**
     * @param mixed $osobaZlecajaca
     */
    public function setOsobaZlecajaca($osobaZlecajaca)
    {
        $this->osobaZlecajaca = $osobaZlecajaca;
    }

    /**
     * Set dataWprowadzenia
     *
     * @param \DateTime $dataWprowadzenia
     * @return ZdarzenieTechniczne
     */
    public function setDataWprowadzenia($dataWprowadzenia)
    {
        $this->dataWprowadzenia = $dataWprowadzenia;

        return $this;
    }

    /**
     * Get dataWprowadzenia
     *
     * @return \DateTime 
     */
    public function getDataWprowadzenia()
    {
        return $this->dataWprowadzenia;
    }

    /**
     * Set dataModyfikacji
     *
     * @param \DateTime $dataModyfikacji
     * @return ZdarzenieTechniczne
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
     * Set osobaWprowadzajaca
     *
     * @param Uzytkownik $osobaWprowadzajaca
     * @return ZdarzenieTechniczne
     */
    public function setOsobaWprowadzajaca(Uzytkownik $osobaWprowadzajaca)
    {
        $this->osobaWprowadzajaca = $osobaWprowadzajaca;

        return $this;
    }

    /**
     * Get osobaWprowadzajaca
     *
     * @return Uzytkownik
     */
    public function getOsobaWprowadzajaca()
    {
        return $this->osobaWprowadzajaca;
    }

    /**
     * Set osobaModyfikujaca
     *
     * @param Uzytkownik $osobaModyfikujaca
     * @return ZdarzenieTechniczne
     */
    public function setOsobaModyfikujaca(Uzytkownik $osobaModyfikujaca)
    {
        $this->osobaModyfikujaca = $osobaModyfikujaca;

        return $this;
    }

    /**
     * Get osobaModyfikujaca
     *
     * @return Uzytkownik
     */
    public function getOsobaModyfikujaca()
    {
        return $this->osobaModyfikujaca;
    }

    /**
     * Set rodzajZdarzeniaTechnicznego
     *
     * @param RodzajZdarzeniaTechnicznego $rodzajZdarzeniaTechnicznego
     * @return ZdarzenieTechniczne
     */
    public function setRodzajZdarzeniaTechnicznego(RodzajZdarzeniaTechnicznego $rodzajZdarzeniaTechnicznego)
    {
        $this->rodzajZdarzeniaTechnicznego = $rodzajZdarzeniaTechnicznego;

        return $this;
    }

    /**
     * Get rodzajZdarzeniaTechnicznego
     *
     * @return RodzajZdarzeniaTechnicznego
     */
    public function getRodzajZdarzeniaTechnicznego()
    {
        return $this->rodzajZdarzeniaTechnicznego;
    }

    /**
     * Add uczestnikZdarzeniaTechnicznego
     *
     * @param UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego
     * @return ZdarzenieTechniczne
     */
    public function addUczestnikZdarzeniaTechnicznego(UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego)
    {
        $this->uczestnikZdarzeniaTechnicznego[] = $uczestnikZdarzeniaTechnicznego;
        $uczestnikZdarzeniaTechnicznego->setZdarzenieTechniczne($this);

        return $this;
    }

    /**
     * Remove uczestnikZdarzeniaTechnicznego
     *
     * @param UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego
     */
    public function removeUczestnikZdarzeniaTechnicznego(UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego)
    {
        $this->uczestnikZdarzeniaTechnicznego->removeElement($uczestnikZdarzeniaTechnicznego);
    }

    /**
     * Get uczestnikZdarzeniaTechnicznego
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUczestnikZdarzeniaTechnicznego()
    {
        return $this->uczestnikZdarzeniaTechnicznego;
    }

    /**
     * @return mixed
     */
    public function getOddzialFirmy()
    {
        return $this->oddzialFirmy;
    }

    /**
     * @param mixed $oddzialFirmy
     * @return $this
     */
    public function setOddzialFirmy(Oddzial $oddzialFirmy = null)
    {
        $this->oddzialFirmy = $oddzialFirmy;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDlugoscGeo()
    {
        return $this->dlugoscGeo;
    }

    /**
     * @param mixed $dlugoscGeo
     */
    public function setDlugoscGeo($dlugoscGeo)
    {
        $this->dlugoscGeo = $dlugoscGeo;
    }

    /**
     * @return float
     */
    public function getSzerokoscGeo()
    {
        return $this->szerokoscGeo;
    }

    /**
     * @param float $szerokoscGeo
     */
    public function setSzerokoscGeo($szerokoscGeo)
    {
        $this->szerokoscGeo = $szerokoscGeo;
    }

    /**
     * @return string
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * @param string $opis
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get receptury
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getReceptury()
    {
        return $this->receptury;
    }

    /**
     * Is Receptury exist
     *
     * @return bool
     */
    public function isReceptury()
    {
        $resp = $this->getReceptury()->count() > 0 ? true : false;

        return $resp;
    }

    /**
     * Add raportyTechniczne
     *
     * @param RaportTechniczny $raportTechniczny
     * @return ZdarzenieTechniczne
     */
    public function addRaportyTechniczne(RaportTechniczny $raportTechniczny)
    {
        if(!$this->raportyTechniczne->contains($raportTechniczny))
        {
            $this->raportyTechniczne->add($raportTechniczny);
        }

        return $this;
    }

    /**
     * Remove raportyTechniczne
     *
     * @param RaportTechniczny $raportTechniczny
     */
    public function removeRaportyTechniczne(RaportTechniczny $raportTechniczny)
    {
        $this->raportyTechniczne->removeElement($raportTechniczny);
    }

    /**
     * Get raportyTechniczne
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRaportyTechniczne()
    {
        return $this->raportyTechniczne;
    }

    /**
     * Is RaportTechniczny exist
     *
     * @return bool
     */
    public function isRaportTechniczny()
    {
        $resp = $this->raportyTechniczne->count() > 0 ? true : false;

        return $resp;
    }

    /**
     * @param Notatka $notatka
     *
     * @return $this
     */
    public function addNotatki(Notatka $notatka)
    {
        if(!$this->notatki->contains($notatka))
        {
            $this->notatki->add($notatka);
        }

        return $this;
    }

    /**
     * @param Notatka $notatka
     */
    public function removeNotatki(Notatka $notatka)
    {
        $this->notatki->remove($notatka);
    }

    /**
     * @return mixed
     */
    public function getNotatki()
    {
        return $this->notatki;
    }



    /**
     * Is RaportTechniczny exist
     *
     * @return bool
     */
    public function isNotatka()
    {
        $resp = $this->notatki->count() > 0 ? true : false;

        return $resp;
    }

    /**
     * Add raportyZuzyc
     *
     * @param RaportZuzycia $raportZuzycia
     * @return ZdarzenieTechniczne
     */
    public function addRaportyZuzyc(RaportZuzycia $raportZuzycia)
    {
        if(!$this->raportyZuzyc->contains($raportZuzycia))
        {
            $this->raportyZuzyc->add($raportZuzycia);
        }

        return $this;
    }

    /**
     * Remove raportyZuzyc
     *
     * @param RaportZuzycia $raportZuzycia
     */
    public function removeRaportyZuzyc(RaportZuzycia $raportZuzycia)
    {
        $this->raportyZuzyc->removeElement($raportZuzycia);
    }

    /**
     * Get raportyZuzyc
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRaportyZuzyc()
    {
        return $this->raportyZuzyc;
    }

    public function isRaportZuzycia()
    {
        $resp = $this->getRaportyZuzyc()->count() > 0 ? true : false;

        return $resp;
    }

    /**
     * @param string $daneKontaktowe
     */
    public function setDaneKontaktowe($daneKontaktowe)
    {
        $this->daneKontaktowe = $daneKontaktowe;
    }

    /**
     * @return string
     */
    public function getDaneKontaktowe()
    {
        return $this->daneKontaktowe;
    }

    /**
     * @param string $elementyDoLakierowania
     */
    public function setElementyDoLakierowania($elementyDoLakierowania)
    {
        $this->elementyDoLakierowania = $elementyDoLakierowania;
    }

    /**
     * @return string
     */
    public function getElementyDoLakierowania()
    {
        return $this->elementyDoLakierowania;
    }

    /**
     * @param string $produkty
     */
    public function setProdukty($produkty)
    {
        $this->produkty = $produkty;
    }

    /**
     * @return string
     */
    public function getProdukty()
    {
        return $this->produkty;
    }

    /**
     *  @return bool
     */
    public function isZalacznik()
    {
        $finder = new Finder();
        $fileSystem = new Filesystem();
        if($fileSystem->exists('uploads/zalaczniki/'.$this->getId().'/'))
        {
            $finder->files()->in('uploads/zalaczniki/'.$this->getId().'/');
        }else{
            $finder = null;
        }

        $resp = $finder != null ? true : false;

        return  $resp;
    }
}
