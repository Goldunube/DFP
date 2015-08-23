<?php

namespace GCSV\DniWolneBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TerminUrlopu
 *
 * @ORM\Table(name="uzytkownicy_terminy_urlopow")
 * @ORM\Entity(repositoryClass="GCSV\DniWolneBundle\Entity\TerminUrlopuRepository")
 */
class TerminUrlopu
{
    const URLOP = 1;
    const ZWOLNIENIE = 2;

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
     * @ORM\Column(name="start", type="date")
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="koniec", type="date")
     */
    private $koniec;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_zgloszenia", type="datetime")
     */
    private $dataZgloszenia;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(nullable=false)
     */
    private $osoba;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(nullable=true)
     */
    private $zatwierdzil;

    /**
     * @var integer
     * @ORM\Column(name="typ", nullable=false)
     */
    private $typ = self::URLOP;


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
     * Set start
     *
     * @param \DateTime $start
     * @return Urlop
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set koniec
     *
     * @param \DateTime $koniec
     * @return Urlop
     */
    public function setKoniec($koniec)
    {
        $this->koniec = $koniec;

        return $this;
    }

    /**
     * Get koniec
     *
     * @return \DateTime
     */
    public function getKoniec()
    {
        return $this->koniec;
    }

    /**
     * @return \DateTime
     */
    public function getDataZgloszenia()
    {
        return $this->dataZgloszenia;
    }

    /**
     * @param \DateTime $dataZgloszenia
     */
    public function setDataZgloszenia($dataZgloszenia)
    {
        $this->dataZgloszenia = $dataZgloszenia;
    }

    /**
     * @return mixed
     */
    public function getOsoba()
    {
        return $this->osoba;
    }

    /**
     * @param mixed $osoba
     */
    public function setOsoba($osoba)
    {
        $this->osoba = $osoba;
    }

    /**
     * @return mixed
     */
    public function getZatwierdzil()
    {
        return $this->zatwierdzil;
    }

    /**
     * @param mixed $zatwierdzil
     */
    public function setZatwierdzil($zatwierdzil)
    {
        $this->zatwierdzil = $zatwierdzil;
    }

    /**
     * @return int
     */
    public function getTyp()
    {
        return $this->typ;
    }

    /**
     * @param int $typ
     */
    public function setTyp($typ)
    {
        $this->typ = $typ;
    }

    /**
     * Get ilość dni
     */
    public function getIloscDni($dataOd = null, $dataDo = null)
    {
        $dataTemp = array();
        $interval = new \DateInterval('P1D');
        $period = new \DatePeriod($this->start,$interval,$this->koniec->modify('+1 day'));
        if(isset($dataOd) && isset($dataDo))
        {
            foreach($period as $dzien)
            {
                if($dzien >= $dataOd and $dzien <= $dataDo)
                {
                    if($dzien->format('w') != 6 and $dzien->format('w') != 0)
                    {
                        array_push($dataTemp,$dzien);
                    }
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
