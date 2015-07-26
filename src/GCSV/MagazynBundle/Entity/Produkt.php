<?php

namespace GCSV\MagazynBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use GCSV\RaportBundle\Entity\RaportZuzyciaProdukt;

/**
 * Produkt
 *
 * @ORM\Table(name="produkty")
 * @ORM\Entity(repositoryClass="GCSV\MagazynBundle\Entity\ProduktRepository")
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
     * @ORM\Column(name="indeks", type="string", length=120, unique=true)
     */
    private $indeks;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=255)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="jednostka", type="string", length=5, nullable=true)
     */
    private $jednostka;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\MagazynBundle\Entity\StanMagazynuMAX",mappedBy="produkt",cascade={"persist","remove"})
     */
    private $stanyMagazynoweMAX;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\MagazynBundle\Entity\StanMagazynuWirtualny",mappedBy="produkt",cascade={"persist","remove"})
     */
    private $stanyMagazynoweWirtualne;

    /**
     * @ORM\OneToMany(targetEntity="GCSV\RaportBundle\Entity\RaportZuzyciaProdukt",mappedBy="produkt")
     */
    private $raportZuzyciaProdukty;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stanyMagazynoweMAX = new ArrayCollection();
        $this->stanyMagazynoweWirtualne = new ArrayCollection();
        $this->raportZuzyciaProdukty = new ArrayCollection();
    }

    public function __toString()
    {
        return (string) $this->getIndeks();
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
     * Set indeks
     *
     * @param string $indeks
     * @return Produkt
     */
    public function setIndeks($indeks)
    {
        $this->indeks = $indeks;

        return $this;
    }

    /**
     * Get indeks
     *
     * @return string
     */
    public function getIndeks()
    {
        return $this->indeks;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return Produkt
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * @return string
     */
    public function getJednostka()
    {
        return $this->jednostka;
    }
    /**
     * @param string $jednostka
     * @return Produkt
     */
    public function setJednostka($jednostka)
    {
        $this->jednostka = $jednostka;

        return $this;
    }

    /**
     * Add stanyMagazynoweMAX
     *
     * @param StanMagazynuMAX $stanyMagazynoweMAX
     * @return Produkt
     */
    public function addStanyMagazynoweMAX(StanMagazynuMAX $stanyMagazynoweMAX)
    {
        if(!$this->stanyMagazynoweMAX->contains($stanyMagazynoweMAX))
        {
            $this->stanyMagazynoweMAX->add($stanyMagazynoweMAX);
        }
    }

    /**
     * Remove stanyMagazynoweMAX
     *
     * @param StanMagazynuMAX $stanyMagazynoweMAX
     */
    public function removeStanyMagazynoweMAX(StanMagazynuMAX $stanyMagazynoweMAX)
    {
        $this->stanyMagazynoweMAX->removeElement($stanyMagazynoweMAX);
    }

    /**
     * Get stanyMagazynoweMAX
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStanyMagazynoweMAX()
    {
        return $this->stanyMagazynoweMAX;
    }

    /**
     * Add stanyMagazynoweWirtualne
     *
     * @param StanMagazynuWirtualny $stanyMagazynoweWirtualne
     * @return Produkt
     */
    public function addStanyMagazynoweWirtualne(StanMagazynuWirtualny $stanyMagazynoweWirtualne)
    {
        if(!$this->stanyMagazynoweWirtualne->contains($stanyMagazynoweWirtualne))
        {
            $this->stanyMagazynoweWirtualne->add($stanyMagazynoweWirtualne);
        }
    }

    /**
     * Remove stanyMagazynoweWirtualne
     *
     * @param StanMagazynuWirtualny $stanyMagazynoweWirtualne
     */
    public function removeStanyMagazynoweWirtualne(StanMagazynuWirtualny $stanyMagazynoweWirtualne)
    {
        $this->stanyMagazynoweWirtualne->removeElement($stanyMagazynoweWirtualne);
    }

    /**
     * Get stanyMagazynoweWirtualne
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStanyMagazynoweWirtualne()
    {
        return $this->stanyMagazynoweWirtualne;
    }

    /**
     * Add raportZuzyciaProdukt
     *
     * @param RaportZuzyciaProdukt $raportZuzyciaProdukt
     * @return Produkt
     */
    public function addRaportZuzyciaProdukty(RaportZuzyciaProdukt $raportZuzyciaProdukt)
    {
        if(!$this->raportZuzyciaProdukty->contains($raportZuzyciaProdukt))
        {
            $this->raportZuzyciaProdukty->add($raportZuzyciaProdukt);
        }
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
     * Get extended label data. Label and subtext
     */
    public function getLabelExtendedData()
    {
        $data = array();
        $data['label'] = $this->getNazwa();
        $data['subtext'] = $this->getIndeks();

        return $data;
    }
}
