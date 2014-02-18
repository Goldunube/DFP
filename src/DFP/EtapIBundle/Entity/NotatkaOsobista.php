<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * NotatkaOsobista
 *
 * @ORM\Table(name="notatki_osobiste")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\NotatkaOsobistaRepository")
 */
class NotatkaOsobista
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
     * @var string
     *
     * @ORM\Column(name="naglowek", type="string", length=100)
     */
    private $naglowek;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataSporzadzenia", type="datetime")
     */
    private $dataSporzadzenia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataPrzypomnienia", type="datetime")
     */
    private $dataPrzypomnienia;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dataWykonania", type="datetime")
     */
    private $dataWykonania;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Uzytkownik", inversedBy="notatkiOsobiste")
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
     * @return NotatkaOsobista
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
     * Set naglowek
     *
     * @param string $naglowek
     * @return NotatkaOsobista
     */
    public function setNaglowek($naglowek)
    {
        $this->naglowek = $naglowek;
    
        return $this;
    }

    /**
     * Get naglowek
     *
     * @return string 
     */
    public function getNaglowek()
    {
        return $this->naglowek;
    }

    /**
     * Set dataSporzadzenia
     *
     * @param \DateTime $dataSporzadzenia
     * @return NotatkaOsobista
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
     * Set dataPrzypomnienia
     *
     * @param \DateTime $dataPrzypomnienia
     * @return NotatkaOsobista
     */
    public function setDataPrzypomnienia($dataPrzypomnienia)
    {
        $this->dataPrzypomnienia = $dataPrzypomnienia;
    
        return $this;
    }

    /**
     * Get dataPrzypomnienia
     *
     * @return \DateTime 
     */
    public function getDataPrzypomnienia()
    {
        return $this->dataPrzypomnienia;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return NotatkaOsobista
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
     * Set dataWykonania
     *
     * @param \DateTime $dataWykonania
     * @return NotatkaOsobista
     */
    public function setDataWykonania($dataWykonania)
    {
        $this->dataWykonania = $dataWykonania;
    
        return $this;
    }

    /**
     * Get dataWykonania
     *
     * @return \DateTime 
     */
    public function getDataWykonania()
    {
        return $this->dataWykonania;
    }

    /**
     * Set uzytkownik
     *
     * @param Uzytkownik $uzytkownik
     * @return NotatkaOsobista
     */
    public function setUzytkownik(Uzytkownik $uzytkownik = null)
    {
        $this->uzytkownik = $uzytkownik;
    
        return $this;
    }

    /**
     * Get uzytkownik
     *
     * @return Uzytkownik
     */
    public function getUzytkownik()
    {
        return $this->uzytkownik;
    }
}