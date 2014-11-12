<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaHandlowa
 *
 * @ORM\Table(name="oferty_handlowe")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\OfertaHandlowaRepository")
 */
class OfertaHandlowa
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
     * @var \DateTime
     *
     * @ORM\Column(name="data_zlozenia_zamowienia", type="datetime")
     */
    private $dataZlozeniaZamowienia;

    /**
     * @var string
     *
     * @ORM\Column(name="info", type="string", length=255, nullable=true)
     */
    private $info;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieOfertyHandlowe")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id")
     */
    private $filia;

    /**
     * @ORM\ManyToOne(targetEntity="Uzytkownik")
     * @ORM\JoinColumn(name="zamawiajacy", referencedColumnName="id", unique=false)
     */
    private $zamawiajacy;

    /**
     * @ORM\ManyToOne(targetEntity="Uzytkownik")
     * @ORM\JoinColumn(name="technik", referencedColumnName="id", unique=false, nullable=true)
     */
    private $technik;

    /**
     * @ORM\ManyToOne(targetEntity="Uzytkownik")
     * @ORM\JoinColumn(name="koordynator", referencedColumnName="id", unique=false, nullable=true)
     */
    private $koordynatorDFP;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = 0;

    /**
     * Dodatkowa informacja wprowadzana przez osobę zamawiającą w momencie zamówienia oferty handlowej
     *
     * @var string
     * @ORM\Column(name="info_zamawiajacy", type="text", nullable=true)
     */
    private $infoZamawiajacego;

    /**
     * Informacja zwrotna dotycząca powodu anulowania / odrzucenia opracowania oferty handlowej ze strony koordynatora DFP
     *
     * @var string
     * @ORM\Column(name="info_anulowana", type="text", nullable=true)
     */
    private $infoAnulacja;

    /**
     * Informacja zwrotna dotycząca powodu anulowania / odrzucenia opracowania oferty handlowej ze strony Technika / Technologa DFP
     *
     * @var string
     * @ORM\Column(name="info_technik", type="text", nullable=true)
     */
    private $infoTechnik;

    /**
     * Produkty dobiera koordynator DFP
     *
     * @ORM\OneToMany(targetEntity="DFP\EtapIBundle\Entity\OfertaProdukt", mappedBy="oferta", cascade={"persist"})
     */
    private $ofertyProdukty;

    /**
     * Dobrane przez Technika systemy malarskie odpowiadajace profilowi działalności klienta
     *
     * @ORM\OneToMany(targetEntity="DFP\EtapIBundle\Entity\OfertaSystem", mappedBy="oferta",cascade={"persist"})
     */
    private $ofertySystemy;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ofertyProdukty = new ArrayCollection();
        $this->ofertySystemy = new ArrayCollection();
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
     * Set info
     *
     * @param string $info
     * @return OfertaHandlowa
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set dataZlozeniaZamowienia
     *
     * @param \DateTime $dataZlozeniaZamowienia
     * @return OfertaHandlowa
     */
    public function setDataZlozeniaZamowienia($dataZlozeniaZamowienia)
    {
        $this->dataZlozeniaZamowienia = $dataZlozeniaZamowienia;
    
        return $this;
    }

    /**
     * Get dataZlozeniaZamowienia
     *
     * @return \DateTime 
     */
    public function getDataZlozeniaZamowienia()
    {
        return $this->dataZlozeniaZamowienia;
    }

    /**
     * Set zamawiajacy
     *
     * @param integer $zamawiajacy
     * @return OfertaHandlowa
     */
    public function setZamawiajacy($zamawiajacy)
    {
        $this->zamawiajacy = $zamawiajacy;
    
        return $this;
    }

    /**
     * Get zamawiajacy
     *
     * @return integer 
     */
    public function getZamawiajacy()
    {
        return $this->zamawiajacy;
    }

    /**
     * Set technik
     *
     * @param integer $technik
     * @return OfertaHandlowa
     */
    public function setTechnik($technik)
    {
        $this->technik = $technik;
    
        return $this;
    }

    /**
     * Get technik
     *
     * @return integer 
     */
    public function getTechnik()
    {
        return $this->technik;
    }

    /**
     * Set koordynatorDFP
     *
     * @param integer $koordynatorDFP
     * @return OfertaHandlowa
     */
    public function setKoordynatorDFP($koordynatorDFP)
    {
        $this->koordynatorDFP = $koordynatorDFP;
    
        return $this;
    }

    /**
     * Get koordynatorDFP
     *
     * @return integer 
     */
    public function getKoordynatorDFP()
    {
        return $this->koordynatorDFP;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return OfertaHandlowa
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return OfertaHandlowa
     */
    public function setFilia(Filia $filia = null)
    {
        $this->filia = $filia;
    
        return $this;
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
     * Set infoZamawiajacego
     *
     * @param string $infoZamawiajacego
     * @return OfertaHandlowa
     */
    public function setInfoZamawiajacego($infoZamawiajacego)
    {
        $this->infoZamawiajacego = $infoZamawiajacego;

        return $this;
    }

    /**
     * Get infoZamawiajacego
     *
     * @return string 
     */
    public function getInfoZamawiajacego()
    {
        return $this->infoZamawiajacego;
    }

    /**
     * Set infoAnulacja
     *
     * @param string $infoAnulacja
     * @return OfertaHandlowa
     */
    public function setInfoAnulacja($infoAnulacja)
    {
        $this->infoAnulacja = $infoAnulacja;

        return $this;
    }

    /**
     * Get infoAnulacja
     *
     * @return string 
     */
    public function getInfoAnulacja()
    {
        return $this->infoAnulacja;
    }

    /**
     * @return string
     */
    public function getInfoTechnik()
    {
        return $this->infoTechnik;
    }

    /**
     * @param string $infoTechnik
     */
    public function setInfoTechnik($infoTechnik)
    {
        $this->infoTechnik = $infoTechnik;
    }

    /**
     * Add ofertyProdukty
     *
     * @param OfertaProdukt $ofertyProdukty
     * @return OfertaHandlowa
     */
    public function addOfertyProdukty(OfertaProdukt $ofertyProdukty)
    {
        $this->ofertyProdukty[] = $ofertyProdukty;

        return $this;
    }

    /**
     * Remove ofertyProdukty
     *
     * @param OfertaProdukt $ofertyProdukty
     */
    public function removeOfertyProdukty(OfertaProdukt $ofertyProdukty)
    {
        $this->ofertyProdukty->removeElement($ofertyProdukty);
    }

    /**
     * Get ofertyProdukty
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfertyProdukty()
    {
        return $this->ofertyProdukty;
    }

    /**
     * Add ofertySystemy
     *
     * @param OfertaSystem $ofertySystemy
     * @return OfertaHandlowa
     */
    public function addOfertySystemy(OfertaSystem $ofertySystemy)
    {
        $this->ofertySystemy[] = $ofertySystemy;

        return $this;
    }

    /**
     * Remove ofertySystemy
     *
     * @param OfertaSystem $ofertySystemy
     */
    public function removeOfertySystemy(OfertaSystem $ofertySystemy)
    {
        $this->ofertySystemy->removeElement($ofertySystemy);
    }

    /**
     * Get ofertySystemy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfertySystemy()
    {
        return $this->ofertySystemy;
    }
}
