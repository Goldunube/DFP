<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaNotatka
 *
 * @ORM\Table(name="notatki_filii")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaNotatkaRepository")
 */
class FiliaNotatka
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
     * @ORM\Column(name="tresc", type="text")
     */
    private $tresc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_sporzadzenia", type="datetime")
     */
    private $dataSporzadzenia;

    /**
     * @var integer
     *
     * @ORM\Column(name="rodzaj", type="integer", nullable=true)
     */
    private $rodzaj = 1;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="koniecEdycji", type="datetime")
     */
    private $koniecEdycji;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieNotatki")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id")
     */
    private $filia;

    /**
     * @var integer
     * 
     * @ORM\ManyToOne(targetEntity="Uzytkownik", inversedBy="filieNotatki")
     * @ORM\JoinColumn(name="uzytkownik_id", referencedColumnName="id")
     */
    private $uzytkownik;


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
     * Set tresc
     *
     * @param string $tresc
     * @return FiliaNotatka
     */
    public function setTresc($tresc)
    {
        $this->tresc = $tresc;
    
        return $this;
    }

    /**
     * Get tresc
     *
     * @return string 
     */
    public function getTresc()
    {
        return $this->tresc;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return FiliaNotatka
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set koniecEdycji
     *
     * @param \DateTime $koniecEdycji
     * @return FiliaNotatka
     */
    public function setKoniecEdycji($koniecEdycji)
    {
        $this->koniecEdycji = $koniecEdycji;
    
        return $this;
    }

    /**
     * Get koniecEdycji
     *
     * @return \DateTime 
     */
    public function getKoniecEdycji()
    {
        return $this->koniecEdycji;
    }

    /**
     * Set dataSporzadzenia
     *
     * @param \DateTime $dataSporzadzenia
     * @return FiliaNotatka
     */
    public function setDataSporzadzenia($dataSporzadzenia)
    {
        $this->dataSporzadzenia = $dataSporzadzenia;
    
        return $this;
    }

    /**
     * Get dataSporzadzenia
     *
     * @return \DateTime 
     */
    public function getDataSporzadzenia()
    {
        return $this->dataSporzadzenia;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaNotatka
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
     * Set uzytkownik
     *
     * @param Uzytkownik $uzytkownik
     * @return FiliaNotatka
     */
    public function setUzytkownik(Uzytkownik $uzytkownik = null)
    {
        $this->uzytkownik = $uzytkownik;
    
        return $this;
    }

    /**
     * Get uzytkownik
     *
     * @return Filia
     */
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }

    /**
     * Get rodzaj
     *
     * @return integer
     */
    public function getRodzaj()
    {
        return $this->rodzaj;
    }

    /**
     * Set rodzaj
     *
     * @param int $rodzaj
     * @return $this
     */
    public function setRodzaj($rodzaj)
    {
        $this->rodzaj = $rodzaj;

        return $this;
    }

}