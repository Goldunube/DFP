<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DaneTechniczneProduktu
 *
 * @ORM\Table(name="dane_techniczne_produktow")
 * @ORM\Entity
 */
class DaneTechniczneProduktu
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
     * @ORM\Column(name="gestosc_min", type="decimal", nullable=true)
     */
    private $gestoscMIN;

    /**
     * @var string
     *
     * @ORM\Column(name="gestosc_max", type="decimal", nullable=true)
     */
    private $gestoscMAX;

    /**
     * @var string
     *
     * @ORM\Column(name="gestosc_mieszaniny_min", type="decimal", nullable=true)
     */
    private $gestoscMieszaninyMIN;

    /**
     * @var string
     *
     * @ORM\Column(name="gestosc_mieszaniny_max", type="decimal", nullable=true)
     */
    private $gestoscMieszaninyMAX;

    /**
     * @var string
     *
     * @ORM\Column(name="stopien_rozdrobnienia_ziarna_min", type="decimal", nullable=true)
     */
    private $stopienRozdrobnieniaZiarnaMIN;

    /**
     * @var string
     *
     * @ORM\Column(name="stopien_rozdrobnienia_ziarna_max", type="decimal", nullable=true)
     */
    private $stopienRozdrobnieniaZiarnaMAX;

    /**
     * @var string
     *
     * @ORM\Column(name="lepkosc_fabryczna_stomer_min", type="decimal", nullable=true)
     */
    private $lepkoscFabrycznaStomerMIN;

    /**
     * @var string
     *
     * @ORM\Column(name="lepkosc_farbyczna_stomer_max", type="decimal", nullable=true)
     */
    private $lepkoscFarbycznaStomerMAX;

    /**
     * @var string
     *
     * @ORM\Column(name="lepkosc_fabryczna_ford_min", type="decimal", nullable=true)
     */
    private $lepkoscFabrycznaFordMIN;

    /**
     * @var string
     *
     * @ORM\Column(name="lepkosc_fabryczna_ford_max", type="decimal", nullable=true)
     */
    private $lepkoscFabrycznaFordMAX;

    /**
     * @var integer
     *
     * @ORM\Column(name="obj_cz_stalych", type="integer", nullable=true)
     */
    private $objZawartoscCzesciStalych;

    /**
     * @var integer
     *
     * @ORM\Column(name="obj_cz_stalych_miesz", type="integer", nullable=true)
     */
    private $objZawartoscCzesciStalychMieszaniny;

    /**
     * @var string
     *
     * @ORM\Column(name="wag_cz_stalych", type="decimal", nullable=true)
     */
    private $wagZawartoscCzesciStalych;

    /**
     * @var string
     *
     * @ORM\Column(name="wag_cz_stalych_miesz", type="decimal", nullable=true)
     */
    private $wagZawartoscCzesciStalychMieszaniny;

    /**
     * @var string
     *
     * @ORM\Column(name="lzo", type="decimal", nullable=true)
     */
    private $lzo;

    /**
     * @var string
     *
     * @ORM\Column(name="lzo_rfu", type="decimal", nullable=true)
     */
    private $lzoRFU;

    /**
     * @var string
     *
     * @ORM\Column(name="rodzaj_produktu", type="string", length=55, nullable=true)
     */
    private $rodzajProduktu;

    /**
     * @var string
     *
     * @ORM\Column(name="kolor", type="string", length=255, nullable=true)
     */
    private $kolor;


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
     * Set gestoscMIN
     *
     * @param string $gestoscMIN
     * @return DaneTechniczneProduktu
     */
    public function setGestoscMIN($gestoscMIN)
    {
        $this->gestoscMIN = $gestoscMIN;

        return $this;
    }

    /**
     * Get gestoscMIN
     *
     * @return string 
     */
    public function getGestoscMIN()
    {
        return $this->gestoscMIN;
    }

    /**
     * Set gestoscMAX
     *
     * @param string $gestoscMAX
     * @return DaneTechniczneProduktu
     */
    public function setGestoscMAX($gestoscMAX)
    {
        $this->gestoscMAX = $gestoscMAX;

        return $this;
    }

    /**
     * Get gestoscMAX
     *
     * @return string 
     */
    public function getGestoscMAX()
    {
        return $this->gestoscMAX;
    }

    /**
     * Set gestoscMieszaninyMIN
     *
     * @param string $gestoscMieszaninyMIN
     * @return DaneTechniczneProduktu
     */
    public function setGestoscMieszaninyMIN($gestoscMieszaninyMIN)
    {
        $this->gestoscMieszaninyMIN = $gestoscMieszaninyMIN;

        return $this;
    }

    /**
     * Get gestoscMieszaninyMIN
     *
     * @return string 
     */
    public function getGestoscMieszaninyMIN()
    {
        return $this->gestoscMieszaninyMIN;
    }

    /**
     * Set gestoscMieszaninyMAX
     *
     * @param string $gestoscMieszaninyMAX
     * @return DaneTechniczneProduktu
     */
    public function setGestoscMieszaninyMAX($gestoscMieszaninyMAX)
    {
        $this->gestoscMieszaninyMAX = $gestoscMieszaninyMAX;

        return $this;
    }

    /**
     * Get gestoscMieszaninyMAX
     *
     * @return string 
     */
    public function getGestoscMieszaninyMAX()
    {
        return $this->gestoscMieszaninyMAX;
    }

    /**
     * Set stopienRozdrobnieniaZiarnaMIN
     *
     * @param string $stopienRozdrobnieniaZiarnaMIN
     * @return DaneTechniczneProduktu
     */
    public function setStopienRozdrobnieniaZiarnaMIN($stopienRozdrobnieniaZiarnaMIN)
    {
        $this->stopienRozdrobnieniaZiarnaMIN = $stopienRozdrobnieniaZiarnaMIN;

        return $this;
    }

    /**
     * Get stopienRozdrobnieniaZiarnaMIN
     *
     * @return string 
     */
    public function getStopienRozdrobnieniaZiarnaMIN()
    {
        return $this->stopienRozdrobnieniaZiarnaMIN;
    }

    /**
     * Set stopienRozdrobnieniaZiarnaMAX
     *
     * @param string $stopienRozdrobnieniaZiarnaMAX
     * @return DaneTechniczneProduktu
     */
    public function setStopienRozdrobnieniaZiarnaMAX($stopienRozdrobnieniaZiarnaMAX)
    {
        $this->stopienRozdrobnieniaZiarnaMAX = $stopienRozdrobnieniaZiarnaMAX;

        return $this;
    }

    /**
     * Get stopienRozdrobnieniaZiarnaMAX
     *
     * @return string 
     */
    public function getStopienRozdrobnieniaZiarnaMAX()
    {
        return $this->stopienRozdrobnieniaZiarnaMAX;
    }

    /**
     * Set lepkoscFabrycznaStomerMIN
     *
     * @param string $lepkoscFabrycznaStomerMIN
     * @return DaneTechniczneProduktu
     */
    public function setLepkoscFabrycznaStomerMIN($lepkoscFabrycznaStomerMIN)
    {
        $this->lepkoscFabrycznaStomerMIN = $lepkoscFabrycznaStomerMIN;

        return $this;
    }

    /**
     * Get lepkoscFabrycznaStomerMIN
     *
     * @return string 
     */
    public function getLepkoscFabrycznaStomerMIN()
    {
        return $this->lepkoscFabrycznaStomerMIN;
    }

    /**
     * Set lepkoscFarbycznaStomerMAX
     *
     * @param string $lepkoscFarbycznaStomerMAX
     * @return DaneTechniczneProduktu
     */
    public function setLepkoscFarbycznaStomerMAX($lepkoscFarbycznaStomerMAX)
    {
        $this->lepkoscFarbycznaStomerMAX = $lepkoscFarbycznaStomerMAX;

        return $this;
    }

    /**
     * Get lepkoscFarbycznaStomerMAX
     *
     * @return string 
     */
    public function getLepkoscFarbycznaStomerMAX()
    {
        return $this->lepkoscFarbycznaStomerMAX;
    }

    /**
     * Set lepkoscFabrycznaFordMIN
     *
     * @param string $lepkoscFabrycznaFordMIN
     * @return DaneTechniczneProduktu
     */
    public function setLepkoscFabrycznaFordMIN($lepkoscFabrycznaFordMIN)
    {
        $this->lepkoscFabrycznaFordMIN = $lepkoscFabrycznaFordMIN;

        return $this;
    }

    /**
     * Get lepkoscFabrycznaFordMIN
     *
     * @return string 
     */
    public function getLepkoscFabrycznaFordMIN()
    {
        return $this->lepkoscFabrycznaFordMIN;
    }

    /**
     * Set lepkoscFabrycznaFordMAX
     *
     * @param string $lepkoscFabrycznaFordMAX
     * @return DaneTechniczneProduktu
     */
    public function setLepkoscFabrycznaFordMAX($lepkoscFabrycznaFordMAX)
    {
        $this->lepkoscFabrycznaFordMAX = $lepkoscFabrycznaFordMAX;

        return $this;
    }

    /**
     * Get lepkoscFabrycznaFordMAX
     *
     * @return string 
     */
    public function getLepkoscFabrycznaFordMAX()
    {
        return $this->lepkoscFabrycznaFordMAX;
    }

    /**
     * Set objZawartoscCzesciStalych
     *
     * @param integer $objZawartoscCzesciStalych
     * @return DaneTechniczneProduktu
     */
    public function setObjZawartoscCzesciStalych($objZawartoscCzesciStalych)
    {
        $this->objZawartoscCzesciStalych = $objZawartoscCzesciStalych;

        return $this;
    }

    /**
     * Get objZawartoscCzesciStalych
     *
     * @return integer 
     */
    public function getObjZawartoscCzesciStalych()
    {
        return $this->objZawartoscCzesciStalych;
    }

    /**
     * Set objZawartoscCzesciStalychMieszaniny
     *
     * @param integer $objZawartoscCzesciStalychMieszaniny
     * @return DaneTechniczneProduktu
     */
    public function setObjZawartoscCzesciStalychMieszaniny($objZawartoscCzesciStalychMieszaniny)
    {
        $this->objZawartoscCzesciStalychMieszaniny = $objZawartoscCzesciStalychMieszaniny;

        return $this;
    }

    /**
     * Get objZawartoscCzesciStalychMieszaniny
     *
     * @return integer 
     */
    public function getObjZawartoscCzesciStalychMieszaniny()
    {
        return $this->objZawartoscCzesciStalychMieszaniny;
    }

    /**
     * Set wagZawartoscCzesciStalych
     *
     * @param string $wagZawartoscCzesciStalych
     * @return DaneTechniczneProduktu
     */
    public function setWagZawartoscCzesciStalych($wagZawartoscCzesciStalych)
    {
        $this->wagZawartoscCzesciStalych = $wagZawartoscCzesciStalych;

        return $this;
    }

    /**
     * Get wagZawartoscCzesciStalych
     *
     * @return string 
     */
    public function getWagZawartoscCzesciStalych()
    {
        return $this->wagZawartoscCzesciStalych;
    }

    /**
     * Set wagZawartoscCzesciStalychMieszaniny
     *
     * @param string $wagZawartoscCzesciStalychMieszaniny
     * @return DaneTechniczneProduktu
     */
    public function setWagZawartoscCzesciStalychMieszaniny($wagZawartoscCzesciStalychMieszaniny)
    {
        $this->wagZawartoscCzesciStalychMieszaniny = $wagZawartoscCzesciStalychMieszaniny;

        return $this;
    }

    /**
     * Get wagZawartoscCzesciStalychMieszaniny
     *
     * @return string 
     */
    public function getWagZawartoscCzesciStalychMieszaniny()
    {
        return $this->wagZawartoscCzesciStalychMieszaniny;
    }

    /**
     * Set lzo
     *
     * @param string $lzo
     * @return DaneTechniczneProduktu
     */
    public function setLzo($lzo)
    {
        $this->lzo = $lzo;

        return $this;
    }

    /**
     * Get lzo
     *
     * @return string 
     */
    public function getLzo()
    {
        return $this->lzo;
    }

    /**
     * Set lzoRFU
     *
     * @param string $lzoRFU
     * @return DaneTechniczneProduktu
     */
    public function setLzoRFU($lzoRFU)
    {
        $this->lzoRFU = $lzoRFU;

        return $this;
    }

    /**
     * Get lzoRFU
     *
     * @return string 
     */
    public function getLzoRFU()
    {
        return $this->lzoRFU;
    }

    /**
     * Set rodzajProduktu
     *
     * @param string $rodzajProduktu
     * @return DaneTechniczneProduktu
     */
    public function setRodzajProduktu($rodzajProduktu)
    {
        $this->rodzajProduktu = $rodzajProduktu;

        return $this;
    }

    /**
     * Get rodzajProduktu
     *
     * @return string 
     */
    public function getRodzajProduktu()
    {
        return $this->rodzajProduktu;
    }

    /**
     * Set kolor
     *
     * @param string $kolor
     * @return DaneTechniczneProduktu
     */
    public function setKolor($kolor)
    {
        $this->kolor = $kolor;

        return $this;
    }

    /**
     * Get kolor
     *
     * @return string 
     */
    public function getKolor()
    {
        return $this->kolor;
    }
}
