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
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="OfertaHandlowaProfilSystem", mappedBy="ofertaHandlowa", cascade={"persist"}, orphanRemoval=true)
     */
    protected $ofertyProfileSystemy;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ofertyProfileSystemy = new ArrayCollection();
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
     * Add ofertyProfileSystemy
     *
     * @param OfertaHandlowaProfilSystem $ofertyProfileSystemy
     * @return OfertaHandlowa
     */
    public function addOfertyProfileSystemy(OfertaHandlowaProfilSystem $ofertyProfileSystemy)
    {
        $this->ofertyProfileSystemy[] = $ofertyProfileSystemy;
        $ofertyProfileSystemy->setOfertaHandlowa($this);
    
        return $this;
    }

    /**
     * Remove ofertyProfileSystemy
     *
     * @param OfertaHandlowaProfilSystem $ofertyProfileSystemy
     */
    public function removeOfertyProfileSystemy(OfertaHandlowaProfilSystem $ofertyProfileSystemy)
    {
        $this->ofertyProfileSystemy->removeElement($ofertyProfileSystemy);
    }

    /**
     * Get ofertyProfileSystemy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOfertyProfileSystemy()
    {
        return $this->ofertyProfileSystemy;
    }
}