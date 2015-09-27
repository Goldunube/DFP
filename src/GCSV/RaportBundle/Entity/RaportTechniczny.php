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
     *
     * @ORM\Column(name="tresc", type="text", nullable=false)
     * @Assert\NotBlank()
     */
    private $tresc;

    /**
     * @var string
     *
     * @ORM\Column(name="zalecenia", type="text", nullable=true)
     */
    private $zalecenia;

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
     * @ORM\ManyToOne(targetEntity="GCSV\RaportBundle\Entity\TypRaportuTechnicznego")
     */
    private $typ;

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
     * Set tresc
     *
     * @param string $tresc
     * @return RaportTechniczny
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
     * Set zalecenia
     *
     * @param string $zalecenia
     * @return RaportTechniczny
     */
    public function setZalecenia($zalecenia)
    {
        $this->zalecenia = $zalecenia;

        return $this;
    }

    /**
     * Get zalecenia
     *
     * @return string 
     */
    public function getZalecenia()
    {
        return $this->zalecenia;
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
     * Set typ
     *
     * @param integer $typ
     * @return RaportTechniczny
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;

        return $this;
    }

    /**
     * Get typ
     *
     * @return integer 
     */
    public function getTyp()
    {
        return $this->typ;
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
}
