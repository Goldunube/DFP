<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * UczestnikZdarzeniaTechnicznego
 *
 * @ORM\Table(name="uczestnicy_zdarzen_technicznych")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class UczestnikZdarzeniaTechnicznego
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
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik", inversedBy="uczestnikZdarzeniaTechnicznego")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $osoba;

    /**
     * @ORM\ManyToOne(targetEntity="ZdarzenieTechniczne", inversedBy="uczestnikZdarzeniaTechnicznego")
     * @ORM\JoinColumn(name="zdarzenie_techniczne_id")
     */
    private $zdarzenieTechniczne;

    /**
     * @ORM\OneToMany(targetEntity="TerminZdarzeniaTechnicznego", mappedBy="uczestnikZdarzeniaTechnicznego", cascade={"persist"}, orphanRemoval=true)
     */
    private $terminy;

    /**
     * @var float
     * @ORM\Column(name="dystans",type="integer",nullable=true)
     */
    private $dystans;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->terminy = new ArrayCollection();
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
     * Set osoba
     *
     * @param integer $osoba
     * @return UczestnikZdarzeniaTechnicznego
     */
    public function setOsoba($osoba)
    {
        $this->osoba = $osoba;

        return $this;
    }

    /**
     * Get osoba
     *
     * @return integer 
     */
    public function getOsoba()
    {
        return $this->osoba;
    }

    /**
     * Add terminy
     *
     * @param TerminZdarzeniaTechnicznego $terminy
     * @return ZdarzenieTechniczne
     */
    public function addTerminy(TerminZdarzeniaTechnicznego $terminy)
    {
        $this->terminy[] = $terminy;
        $terminy->setUczestnikZdarzeniaTechnicznego($this);

        return $this;
    }

    /**
     * Remove terminy
     *
     * @param TerminZdarzeniaTechnicznego $terminy
     */
    public function removeTerminy(TerminZdarzeniaTechnicznego $terminy)
    {
        $this->terminy->removeElement($terminy);
    }

    /**
     * Get terminy
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTerminy()
    {
        return $this->terminy;
    }

    /**
     * Set zdarzenieTechniczne
     *
     * @param ZdarzenieTechniczne $zdarzenieTechniczne
     * @return UczestnikZdarzeniaTechnicznego
     */
    public function setZdarzenieTechniczne(ZdarzenieTechniczne $zdarzenieTechniczne = null)
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
     * @return float
     */
    public function getDystans()
    {
        return $this->dystans;
    }

    /**
     * @param float $dystans
     */
    public function setDystans($dystans)
    {
        $this->dystans = $dystans;
    }

    /**
     * Get ilość dni wizyt
     */
    public function ileDniWizyt($dataOd = null, $dataDo = null)
    {
        $dataTemp = array();
        /**
         * @var TerminZdarzeniaTechnicznego $termin
         */
        foreach ($this->terminy as $termin) {
            $interval = new \DateInterval('P1D');
            $period = new \DatePeriod($termin->getRozpoczecieWizyty(),$interval,$termin->getZakonczenieWizyty());
            if(isset($dataOd) && isset($dataDo))
            {
                foreach($period as $dzien)
                {
                    if($dzien >= $dataOd and $dzien <= $dataDo)
                    {
                        array_push($dataTemp,$dzien);
                    }
                }
            }else{
                foreach($period as $dzien)
                {
                    array_push($dataTemp,$dzien);
                }
            }
        }

        $iloscDni = count($dataTemp);

        return $iloscDni;
    }
}
