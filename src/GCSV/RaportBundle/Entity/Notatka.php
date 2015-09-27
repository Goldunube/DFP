<?php

namespace GCSV\RaportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Notatka
 *
 * @ORM\Table(name="notatki_do_zdarzen")
 * @ORM\Entity
 */
class Notatka
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
     * @var boolean
     *
     * @ORM\Column(name="publiczna", type="boolean")
     */
    private $publiczna = false;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="tresc", type="text", nullable=false)
     */
    private $tresc;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="data_utworzenia", type="datetime")
     */
    private $dataUtworzenia;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="data_modyfikacji", type="datetime")
     */
    private $dataModyfikacji;

    /**
     * @var string
     *
     * @ORM\Column(name="rodzaj", type="string", length=25)
     */
    private $rodzaj = "Notatka wewnetrzna";

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="autor", nullable=false)
     */
    private $autor;

    /**
     * @ORM\ManyToOne(targetEntity="GCSV\TechnicalBundle\Entity\ZdarzenieTechniczne", inversedBy="notatki")
     * @ORM\JoinColumn(name="zdarzenie_techniczne_id", nullable=false)
     */
    private $zdarzenieTechniczne;


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
     * Set publiczna
     *
     * @param boolean $publiczna
     * @return Notatka
     */
    public function setPubliczna($publiczna)
    {
        $this->publiczna = $publiczna;

        return $this;
    }

    /**
     * Get publiczna
     *
     * @return boolean 
     */
    public function getPubliczna()
    {
        return $this->publiczna;
    }

    /**
     * Set tresc
     *
     * @param string $tresc
     * @return Notatka
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
     * Set dataUtworzenia
     *
     * @param \DateTime $dataUtworzenia
     * @return Notatka
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
     * @return Notatka
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
     * Set rodzaj
     *
     * @param string $rodzaj
     * @return Notatka
     */
    public function setRodzaj($rodzaj)
    {
        $this->rodzaj = $rodzaj;

        return $this;
    }

    /**
     * Get rodzaj
     *
     * @return string 
     */
    public function getRodzaj()
    {
        return $this->rodzaj;
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
}
