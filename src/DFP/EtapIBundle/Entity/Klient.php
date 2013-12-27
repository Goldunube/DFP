<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Klient
 *
 * @ORM\Table(name="klienci")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\KlientRepository")
 */
class Klient
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
     * @ORM\Column(name="nazwa_pelna", type="string", length=255, nullable=true)
     */
    private $nazwaPelna;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwa_skrocona", type="string", length=120)
     */
    private $nazwaSkrocona;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_zalozenia", type="datetime")
     */
    private $dataZalozenia;

    /**
     * @var string
     *
     * @ORM\Column(name="nip", type="string", length=9)
     */
    private $nip;

    /**
     * @var string
     *
     * @ORM\Column(name="kod_max", type="string", length=9, nullable=true)
     */
    private $kodMax;

    /**
     * @var string
     *
     * @ORM\Column(name="kanal_dystrybucji", type="string", length=60, nullable=true)
     */
    private $kanalDystrybucji;

    /**
     * @var boolean
     *
     * @ORM\Column(name="aktywny", type="boolean")
     */
    private $aktywny;

    /**
     *
     * @ORM\OneToMany(targetEntity="Filia", mappedBy="klient", cascade={"all"})
     */
    protected $filie;

    /**
     * @ORM\ManyToMany(targetEntity="ProfilDzialalnosci", inversedBy="klienci")
     * @ORM\JoinTable(name="klienci_profile_dzialalnosci",
     *      joinColumns={@ORM\JoinColumn(name="klient_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="profil_id", referencedColumnName="id")}
     * )
     */
    private $profileDzialalnosci;

    /**
     * @ORM\ManyToMany(targetEntity="GrupaKlientow", inversedBy="klienci")
     * @ORM\JoinTable(name="klienci_grupy_klientow",
     *      joinColumns={@ORM\JoinColumn(name="klient_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="grupa_id", referencedColumnName="id")}
     *      )
     */
    private $grupyKlientow;

    public function __construct()
    {
        $this->filie = new ArrayCollection();
        $this->grupyKlientow = new ArrayCollection();
        $this->profileDzialalnosci = new ArrayCollection();
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
     * Set nazwaPelna
     *
     * @param string $nazwaPelna
     * @return Klient
     */
    public function setNazwaPelna($nazwaPelna)
    {
        $this->nazwaPelna = $nazwaPelna;
    
        return $this;
    }

    /**
     * Get nazwaPelna
     *
     * @return string 
     */
    public function getNazwaPelna()
    {
        return $this->nazwaPelna;
    }

    /**
     * Set nazwaSkrocona
     *
     * @param string $nazwaSkrocona
     * @return Klient
     */
    public function setNazwaSkrocona($nazwaSkrocona)
    {
        $this->nazwaSkrocona = $nazwaSkrocona;
    
        return $this;
    }

    /**
     * Get nazwaSkrocona
     *
     * @return string 
     */
    public function getNazwaSkrocona()
    {
        return $this->nazwaSkrocona;
    }

    /**
     * Set dataZalozenia
     *
     * @param \DateTime $dataZalozenia
     * @return Klient
     */
    public function setDataZalozenia(\DateTime $dataZalozenia = null)
    {
        $this->dataZalozenia = $dataZalozenia;
    
        return $this;
    }

    /**
     * Get dataZalozenia
     *
     * @return \DateTime 
     */
    public function getDataZalozenia()
    {
        return $this->dataZalozenia;
    }

    /**
     * Set nip
     *
     * @param string $nip
     * @return Klient
     */
    public function setNip($nip)
    {
        $this->nip = $nip;
    
        return $this;
    }

    /**
     * Get nip
     *
     * @return string 
     */
    public function getNip()
    {
        return $this->nip;
    }

    /**
     * Set kodMax
     *
     * @param string $kodMax
     * @return Klient
     */
    public function setKodMax($kodMax)
    {
        $this->kodMax = $kodMax;
    
        return $this;
    }

    /**
     * Get kodMax
     *
     * @return string 
     */
    public function getKodMax()
    {
        return $this->kodMax;
    }

    /**
     * Set kanalDystrybucji
     *
     * @param string $kanalDystrybucji
     * @return Klient
     */
    public function setKanalDystrybucji($kanalDystrybucji)
    {
        $this->kanalDystrybucji = $kanalDystrybucji;
    
        return $this;
    }

    /**
     * Get kanalDystrybucji
     *
     * @return string 
     */
    public function getKanalDystrybucji()
    {
        return $this->kanalDystrybucji;
    }

    /**
     * Set aktywny
     *
     * @param boolean $aktywny
     * @return Klient
     */
    public function setAktywny($aktywny = true)
    {
        $this->aktywny = $aktywny;
    
        return $this;
    }

    /**
     * Get aktywny
     *
     * @return boolean 
     */
    public function getAktywny()
    {
        return $this->aktywny;
    }

    /**
     * Add filie
     *
     * @param \DFP\EtapIBundle\Entity\Filia $filie
     * @return Klient
     */
    public function addFilie(\DFP\EtapIBundle\Entity\Filia $filie)
    {
        $this->filie[] = $filie;
    
        return $this;
    }

    /**
     * Remove filie
     *
     * @param \DFP\EtapIBundle\Entity\Filia $filie
     */
    public function removeFilie(\DFP\EtapIBundle\Entity\Filia $filie)
    {
        $this->filie->removeElement($filie);
    }

    /**
     * Get filie
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFilie()
    {
        return $this->filie;
    }

    /**
     * Add profileDzialalnosci
     *
     * @param \DFP\EtapIBundle\Entity\ProfilDzialalnosci $profilDzialalnosci
     * @return Klient
     */
    public function addProfileDzialalnosci(ProfilDzialalnosci $profilDzialalnosci)
    {
        $profilDzialalnosci->addKlienci($this);
        $this->profileDzialalnosci[] = $profilDzialalnosci;

        return $this;
    }

    /**
     * Remove profileDzialalnosci
     *
     * @param \DFP\EtapIBundle\Entity\ProfilDzialalnosci $profileDzialalnosci
     */
    public function removeProfileDzialalnosci(\DFP\EtapIBundle\Entity\ProfilDzialalnosci $profileDzialalnosci)
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
     * Add grupyKlientow
     *
     * @param \DFP\EtapIBundle\Entity\GrupaKlientow $grupyKlientow
     * @return Klient
     */
    public function addGrupyKlientow(\DFP\EtapIBundle\Entity\GrupaKlientow $grupyKlientow)
    {
        $this->grupyKlientow[] = $grupyKlientow;

        return $this;
    }

    /**
     * Remove grupyKlientow
     *
     * @param \DFP\EtapIBundle\Entity\GrupaKlientow $grupyKlientow
     */
    public function removeGrupyKlientow(\DFP\EtapIBundle\Entity\GrupaKlientow $grupyKlientow)
    {
        $this->grupyKlientow->removeElement($grupyKlientow);
    }

    /**
     * Get grupyKlientow
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrupyKlientow()
    {
        return $this->grupyKlientow;
    }


}