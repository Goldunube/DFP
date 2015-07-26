<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use GCSV\UserBundle\Entity\Uzytkownik;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RaportZuzycia
 *
 * @ORM\Table(name="raporty_zuzyc")
 * @ORM\Entity(repositoryClass="GCSV\RaportBundle\Entity\RaportZuzyciaRepository")
 * @ORM\HasLifecycleCallbacks
 */
class RaportZuzycia
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
     * @ORM\ManyToOne(targetEntity="GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne",inversedBy="raportyZuzyc")
     * @ORM\JoinColumn(name="zdarzenie_techniczne_id", nullable=false)
     */
    private $zdarzenieTechniczne;

    /**
     * @ORM\ManyToOne(targetEntity="GCSV\UserBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="uzytkownik_id", nullable=false)
     */
    private $autor;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="data_utworzenia", type="datetime")
     */
    private $dataUtworzenia;

    /**
     * @var \DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="data_modyfikacji", type="datetime")
     */
    private $dataModyfikacji;

    /**
     * @var boolean
     *
     * @ORM\Column(name="akceptacja", type="boolean")
     */
    private $akceptacja = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="blokada", type="boolean")
     */
    private $blokada = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="korekta", type="boolean")
     */
    private $korekta = false;

    /**
     * @var boolean
     *
     * @ORM\Column(name="wydruk", type="boolean")
     */
    private $wydruk = false;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", nullable=true)
     */
    private $uwagi;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\RaportBundle\Entity\RaportZuzyciaProdukt", mappedBy="raportZuzycia",cascade={"persist"},orphanRemoval=true)
     */
    private $raportZuzyciaProdukty;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="change", field="akceptacja", value="1")
     * @ORM\Column(name="data_akceptacji", type="datetime", nullable=true)
     */
    private $dataAkceptacji;

    /**
     * @Gedmo\Blameable(on="change", field="akceptacja", value="1")
     * @ORM\ManyToOne(targetEntity="GCSV\UserBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="akceptujacy_id", nullable=true)
     */
    private $osobaAkceptujaca;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->raportZuzyciaProdukty = new ArrayCollection();
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
     * Set dataUtworzenia
     *
     * @param \DateTime $dataUtworzenia
     * @return RaportZuzycia
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
     * Set dataModyfikacji
     *
     * @param \DateTime $dataModyfikacji
     * @return RaportZuzycia
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
     * Set akceptacja
     *
     * @param boolean $akceptacja
     * @return RaportZuzycia
     */
    public function setAkceptacja($akceptacja)
    {
        $this->akceptacja = $akceptacja;

        return $this;
    }

    /**
     * Get akceptacja
     *
     * @return boolean 
     */
    public function getAkceptacja()
    {
        return $this->akceptacja;
    }

    /**
     * Set blokada
     *
     * @param boolean $blokada
     * @return RaportZuzycia
     */
    public function setBlokada($blokada)
    {
        $this->blokada = $blokada;

        return $this;
    }

    /**
     * Get blokada
     *
     * @return boolean 
     */
    public function getBlokada()
    {
        return $this->blokada;
    }

    /**
     * Set korekta
     *
     * @param boolean $korekta
     * @return RaportZuzycia
     */
    public function setKorekta($korekta)
    {
        $this->korekta = $korekta;

        return $this;
    }

    /**
     * Get korekta
     *
     * @return boolean 
     */
    public function getKorekta()
    {
        return $this->korekta;
    }

    /**
     * Set wydruk
     *
     * @param boolean $wydruk
     * @return RaportZuzycia
     */
    public function setWydruk($wydruk)
    {
        $this->wydruk = $wydruk;

        return $this;
    }

    /**
     * Get wydruk
     *
     * @return boolean 
     */
    public function getWydruk()
    {
        return $this->wydruk;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     * @return RaportZuzycia
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
     * Set zdarzenieTechniczne
     *
     * @param ZdarzenieTechniczne $zdarzenieTechniczne
     * @return RaportZuzycia
     */
    public function setZdarzenieTechniczne(ZdarzenieTechniczne $zdarzenieTechniczne)
    {
        $this->zdarzenieTechniczne = $zdarzenieTechniczne;

        return $this;
    }

    /**
     * Get zdarzenieTechniczne
     *
     * @return RaportZuzycia
     */
    public function getZdarzenieTechniczne()
    {
        return $this->zdarzenieTechniczne;
    }

    /**
     * Set autor
     *
     * @param Uzytkownik $autor
     * @return RaportTechniczny
     */
    public function setAutor(Uzytkownik $autor)
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
     * Add raportZuzyciaProdukt
     *
     * @param RaportZuzyciaProdukt $raportZuzyciaProdukt
     * @return RaportZuzycia
     */
    public function addRaportZuzyciaProdukty(RaportZuzyciaProdukt $raportZuzyciaProdukt)
    {
        if(!$this->raportZuzyciaProdukty->contains($raportZuzyciaProdukt))
        {
            $this->raportZuzyciaProdukty->add($raportZuzyciaProdukt);
        }
        $raportZuzyciaProdukt->setRaportZuzycia($this);
    }

    /**
     * Remove raportZuzyciaProdukt
     *
     * @param RaportZuzyciaProdukt $raportZuzyciaProdukt
     */
    public function removeRaportZuzyciaProdukty(RaportZuzyciaProdukt $raportZuzyciaProdukt)
    {
        $this->raportZuzyciaProdukty->removeElement($raportZuzyciaProdukt);
    }

    /**
     * Get raportZuzyciaProdukt
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRaportZuzyciaProdukty()
    {
        return $this->raportZuzyciaProdukty;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function postPersist()
    {
        /**
         * @var RaportZuzyciaProdukt $raportZuzyciaProdukt
         */
        foreach($this->getRaportZuzyciaProdukty() as $raportZuzyciaProdukt)
        {
            if(($raportZuzyciaProdukt->getIloscZuzyta() == null) AND ($raportZuzyciaProdukt->getIloscZostawiona() == null))
            {
                $this->getRaportZuzyciaProdukty()->removeElement($raportZuzyciaProdukt);
            }
        }
    }

    /**
     * @return \DateTime
     */
    public function getDataAkceptacji()
    {
        return $this->dataAkceptacji;
    }

    /**
     * @param \DateTime $dataAkceptacji
     */
    public function setDataAkceptacji($dataAkceptacji)
    {
        $this->dataAkceptacji = $dataAkceptacji;
    }

    /**
     * @return mixed
     */
    public function getOsobaAkceptujaca()
    {
        return $this->osobaAkceptujaca;
    }

    /**
     * @param mixed $osobaAkceptujaca
     */
    public function setOsobaAkceptujaca($osobaAkceptujaca)
    {
        $this->osobaAkceptujaca = $osobaAkceptujaca;
    }
}
