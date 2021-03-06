<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SuszenieProdukt
 *
 * @ORM\Table(name="suszenie_produkty")
 * @ORM\Entity
 */
class SuszenieProdukt
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
     * @var integer
     *
     * @ORM\Column(name="pylosuchosc_temperatura_otoczenie", type="integer", nullable=true)
     */
    private $pylosuchoscTemperaturaOtoczenie;

    /**
     * @var integer
     *
     * @ORM\Column(name="pylosuchosc_czas_otoczenie", type="integer", nullable=true)
     */
    private $pylosuchoscCzasOtoczenie;

    /**
     * @var integer
     *
     * @ORM\Column(name="dotyk_temperatura_otoczenie", type="integer", nullable=true)
     */
    private $dotykTemperaturaOtoczenie;

    /**
     * @var integer
     *
     * @ORM\Column(name="dotyk_czas_otoczenie", type="integer", nullable=true)
     */
    private $dotykCzasOtoczenie;

    /**
     * @var integer
     *
     * @ORM\Column(name="utwardzenie_temperatura_otoczenie", type="integer", nullable=true)
     */
    private $utwardzenieTemperaturaOtoczenie;

    /**
     * @var integer
     *
     * @ORM\Column(name="utwardzenie_czas_otoczenie", type="integer", nullable=true)
     */
    private $utwardzenieCzasOtoczenie;

    /**
     * @var integer
     *
     * @ORM\Column(name="wstepne_temperatura_kabina", type="integer", nullable=true)
     */
    private $wstepneTemperaturaKabina;

    /**
     * @var integer
     *
     * @ORM\Column(name="wstepne_czas_kabina", type="integer", nullable=true)
     */
    private $wstepneCzasKabina;

    /**
     * @var integer
     *
     * @ORM\Column(name="docelowe_temperatura_kabina", type="integer", nullable=true)
     */
    private $doceloweTemperaturaKabina;

    /**
     * @var integer
     *
     * @ORM\Column(name="docelowe_czas_kabina", type="integer", nullable=true)
     */
    private $doceloweCzasKabina;

    /**
     * @var string
     *
     * @ORM\Column(name="infrared", type="decimal", nullable=true)
     */
    private $infrared;

    /**
     * @var string
     *
     * @ORM\Column(name="ultraviolet", type="decimal", nullable=true)
     */
    private $ultraviolet;


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
     * Set pylosuchoscTemperaturaOtoczenie
     *
     * @param integer $pylosuchoscTemperaturaOtoczenie
     * @return SuszenieProdukt
     */
    public function setPylosuchoscTemperaturaOtoczenie($pylosuchoscTemperaturaOtoczenie)
    {
        $this->pylosuchoscTemperaturaOtoczenie = $pylosuchoscTemperaturaOtoczenie;

        return $this;
    }

    /**
     * Get pylosuchoscTemperaturaOtoczenie
     *
     * @return integer 
     */
    public function getPylosuchoscTemperaturaOtoczenie()
    {
        return $this->pylosuchoscTemperaturaOtoczenie;
    }

    /**
     * Set pylosuchoscCzasOtoczenie
     *
     * @param integer $pylosuchoscCzasOtoczenie
     * @param $jednostka
     * @return SuszenieProdukt
     */
    public function setPylosuchoscCzasOtoczenie($pylosuchoscCzasOtoczenie, $jednostka = 0)
    {
        if($jednostka == 2)
        {
            $pylosuchoscCzasOtoczenie = $pylosuchoscCzasOtoczenie * 60 * 60;
        }elseif($jednostka == 1)
        {
            $pylosuchoscCzasOtoczenie = $pylosuchoscCzasOtoczenie * 60;
        }

        $this->pylosuchoscCzasOtoczenie = round($pylosuchoscCzasOtoczenie);

        return $this;
    }

    /**
     * Get pylosuchoscCzasOtoczenie
     *
     * @return integer 
     */
    public function getPylosuchoscCzasOtoczenie()
    {
        return $this->pylosuchoscCzasOtoczenie;
    }

    /**
     * Set dotykTemperaturaOtoczenie
     *
     * @param integer $dotykTemperaturaOtoczenie
     * @return SuszenieProdukt
     */
    public function setDotykTemperaturaOtoczenie($dotykTemperaturaOtoczenie)
    {
        $this->dotykTemperaturaOtoczenie = $dotykTemperaturaOtoczenie;

        return $this;
    }

    /**
     * Get dotykTemperaturaOtoczenie
     *
     * @return integer 
     */
    public function getDotykTemperaturaOtoczenie()
    {
        return $this->dotykTemperaturaOtoczenie;
    }

    /**
     * Set dotykCzasOtoczenie
     *
     * @param integer $dotykCzasOtoczenie
     * @param $jednostka
     * @return SuszenieProdukt
     */
    public function setDotykCzasOtoczenie($dotykCzasOtoczenie, $jednostka = 0)
    {
        if($jednostka == 2)
        {
            $dotykCzasOtoczenie = $dotykCzasOtoczenie * 60 * 60;
        }elseif($jednostka == 1)
        {
            $dotykCzasOtoczenie = $dotykCzasOtoczenie * 60;
        }

        $this->dotykCzasOtoczenie = round($dotykCzasOtoczenie);

        return $this;
    }

    /**
     * Get dotykCzasOtoczenie
     *
     * @return integer 
     */
    public function getDotykCzasOtoczenie()
    {
        return $this->dotykCzasOtoczenie;
    }

    /**
     * Set utwardzenieTemperaturaOtoczenie
     *
     * @param integer $utwardzenieTemperaturaOtoczenie
     * @return SuszenieProdukt
     */
    public function setUtwardzenieTemperaturaOtoczenie($utwardzenieTemperaturaOtoczenie)
    {
        $this->utwardzenieTemperaturaOtoczenie = $utwardzenieTemperaturaOtoczenie;

        return $this;
    }

    /**
     * Get utwardzenieTemperaturaOtoczenie
     *
     * @return integer 
     */
    public function getUtwardzenieTemperaturaOtoczenie()
    {
        return $this->utwardzenieTemperaturaOtoczenie;
    }

    /**
     * Set utwardzenieCzasOtoczenie
     *
     * @param integer $utwardzenieCzasOtoczenie
     * @param $jednostka
     * @return SuszenieProdukt
     */
    public function setUtwardzenieCzasOtoczenie($utwardzenieCzasOtoczenie, $jednostka = 0)
    {
        if($jednostka == 2)
        {
            $utwardzenieCzasOtoczenie = $utwardzenieCzasOtoczenie * 60 * 60;
        }elseif($jednostka == 1)
        {
            $utwardzenieCzasOtoczenie = $utwardzenieCzasOtoczenie * 60;
        }

        $this->utwardzenieCzasOtoczenie = round($utwardzenieCzasOtoczenie);

        return $this;
    }

    /**
     * Get utwardzenieCzasOtoczenie
     *
     * @return integer 
     */
    public function getUtwardzenieCzasOtoczenie()
    {
        return $this->utwardzenieCzasOtoczenie;
    }

    /**
     * Set wstepneTemperaturaKabina
     *
     * @param integer $wstepneTemperaturaKabina
     * @return SuszenieProdukt
     */
    public function setWstepneTemperaturaKabina($wstepneTemperaturaKabina)
    {
        $this->wstepneTemperaturaKabina = $wstepneTemperaturaKabina;

        return $this;
    }

    /**
     * Get wstepneTemperaturaKabina
     *
     * @return integer 
     */
    public function getWstepneTemperaturaKabina()
    {
        return $this->wstepneTemperaturaKabina;
    }

    /**
     * Set wstepneCzasKabina
     *
     * @param integer $wstepneCzasKabina
     * @param int $jednostka
     * @return SuszenieProdukt
     */
    public function setWstepneCzasKabina($wstepneCzasKabina, $jednostka = 0)
    {
        if($jednostka == 2)
        {
            $wstepneCzasKabina = $wstepneCzasKabina * 60 * 60;
        }elseif($jednostka == 1)
        {
            $wstepneCzasKabina = $wstepneCzasKabina * 60;
        }

        $this->wstepneCzasKabina = round($wstepneCzasKabina);

        return $this;
    }

    /**
     * Get wstepneCzasKabina
     *
     * @return integer 
     */
    public function getWstepneCzasKabina()
    {
        return $this->wstepneCzasKabina;
    }

    /**
     * Set doceloweTemperaturaKabina
     *
     * @param integer $doceloweTemperaturaKabina
     * @return SuszenieProdukt
     */
    public function setDoceloweTemperaturaKabina($doceloweTemperaturaKabina)
    {
        $this->doceloweTemperaturaKabina = $doceloweTemperaturaKabina;

        return $this;
    }

    /**
     * Get doceloweTemperaturaKabina
     *
     * @return integer 
     */
    public function getDoceloweTemperaturaKabina()
    {
        return $this->doceloweTemperaturaKabina;
    }

    /**
     * Set doceloweCzasKabina
     *
     * @param integer $doceloweCzasKabina
     * @param int $jednostka
     * @return SuszenieProdukt
     */
    public function setDoceloweCzasKabina($doceloweCzasKabina, $jednostka = 0)
    {
        if($jednostka == 2)
        {
            $doceloweCzasKabina = $doceloweCzasKabina * 60 * 60;
        }elseif($jednostka == 1)
        {
            $doceloweCzasKabina = $doceloweCzasKabina * 60;
        }

        $this->doceloweCzasKabina = round($doceloweCzasKabina);

        return $this;
    }

    /**
     * Get doceloweCzasKabina
     *
     * @return integer 
     */
    public function getDoceloweCzasKabina()
    {
        return $this->doceloweCzasKabina;
    }

    /**
     * Set infrared
     *
     * @param integer $infrared
     * @return SuszenieProdukt
     */
    public function setInfrared($infrared)
    {
        $this->infrared = $infrared;

        return $this;
    }

    /**
     * Get infrared
     *
     * @return integer 
     */
    public function getInfrared()
    {
        return $this->infrared;
    }

    /**
     * Set ultraviolet
     *
     * @param integer $ultraviolet
     * @return SuszenieProdukt
     */
    public function setUltraviolet($ultraviolet)
    {
        $this->ultraviolet = $ultraviolet;

        return $this;
    }

    /**
     * Get ultraviolet
     *
     * @return integer 
     */
    public function getUltraviolet()
    {
        return $this->ultraviolet;
    }
}
