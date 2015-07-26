<?php

namespace GCSV\TechnicalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use GCSV\TechnicalBundle\Validator as TerminAssert;

/**
 * TerminZdarzeniaTechnicznego
 *
 * @ORM\Table(name="terminy_zdarzen_technicznych")
 * @ORM\Entity(repositoryClass="GCSV\TechnicalBundle\Entity\TerminZdarzeniaTechnicznegoRepository")
 * @ORM\HasLifecycleCallbacks()
 * @TerminAssert\DateRange()
 */
class TerminZdarzeniaTechnicznego
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
     * @ORM\Column(name="rozpoczecie", type="datetime")
     */
    private $rozpoczecieWizyty;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="zakonczenie", type="datetime")
     */
    private $zakonczenieWizyty;

    /**
     * @ORM\ManyToOne(targetEntity="StatusZdarzeniaTechnicznego")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity="UczestnikZdarzeniaTechnicznego", inversedBy="terminy")
     * @ORM\JoinColumn(name="uczestnik_id")
     */
    private $uczestnikZdarzeniaTechnicznego;


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
     * Set rozpoczecieWizyty
     *
     * @param \DateTime $rozpoczecieWizyty
     * @return TerminZdarzeniaTechnicznego
     */
    public function setRozpoczecieWizyty($rozpoczecieWizyty)
    {
        $this->rozpoczecieWizyty = $rozpoczecieWizyty;

        return $this;
    }

    /**
     * Get rozpoczecieWizyty
     *
     * @return \DateTime 
     */
    public function getRozpoczecieWizyty()
    {
        return $this->rozpoczecieWizyty;
    }

    /**
     * Set zakonczenieWizyty
     *
     * @param \DateTime $zakonczenieWizyty
     * @return TerminZdarzeniaTechnicznego
     */
    public function setZakonczenieWizyty($zakonczenieWizyty)
    {
        $this->zakonczenieWizyty = $zakonczenieWizyty;

        return $this;
    }

    /**
     * Get zakonczenieWizyty
     *
     * @return \DateTime 
     */
    public function getZakonczenieWizyty()
    {
        return $this->zakonczenieWizyty;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return TerminZdarzeniaTechnicznego
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
     * Set uczestnikZdarzeniaTechnicznego
     *
     * @param UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego
     * @return TerminZdarzeniaTechnicznego
     */
    public function setUczestnikZdarzeniaTechnicznego(UczestnikZdarzeniaTechnicznego $uczestnikZdarzeniaTechnicznego = null)
    {
        $this->uczestnikZdarzeniaTechnicznego = $uczestnikZdarzeniaTechnicznego;

        return $this;
    }

    /**
     * Get uczestnikZdarzeniaTechnicznego
     *
     * @return UczestnikZdarzeniaTechnicznego
     */
    public function getUczestnikZdarzeniaTechnicznego()
    {
        return $this->uczestnikZdarzeniaTechnicznego;
    }

    /**
     * Get ilość dni
     */
    public function getIloscDni($dataOd = null, $dataDo = null)
    {
        $dataTemp = array();
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($this->rozpoczecieWizyty,$interval,$this->zakonczenieWizyty);
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

        $iloscDni = count($dataTemp);

        return $iloscDni;
    }
}
