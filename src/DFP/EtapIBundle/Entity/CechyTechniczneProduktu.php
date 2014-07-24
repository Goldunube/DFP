<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CechyTechniczneProduktu
 *
 * @ORM\Table(name="cechy_techniczne_produktow")
 * @ORM\Entity
 */
class CechyTechniczneProduktu
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
     * @ORM\Column(name="wlasciwosci_mechaniczne", type="integer", nullable=true)
     */
    private $wlasciwosciMechaniczne;

    /**
     * @var string
     *
     * @ORM\Column(name="test_erichsen", type="decimal", nullable=true)
     */
    private $testErichsen;

    /**
     * @var string
     *
     * @ORM\Column(name="udarnosc", type="decimal", nullable=true)
     */
    private $udarnosc;

    /**
     * @var string
     *
     * @ORM\Column(name="proba_mandrela", type="decimal", nullable=true)
     */
    private $probaMandrela;

    /**
     * @var integer
     *
     * @ORM\Column(name="plastycznosc", type="integer", nullable=true)
     */
    private $plastycznosc;

    /**
     * @var integer
     *
     * @ORM\Column(name="odpornosc_scieranie", type="integer", nullable=true)
     */
    private $odpornoscScieranie;

    /**
     * @var array
     *
     * @ORM\Column(name="odpornosc_media", type="array", nullable=true)
     */
    private $odpornoscMedia;

    /**
     * @var integer
     *
     * @ORM\Column(name="odpornosc_mglasolna", type="integer", nullable=true)
     */
    private $odpornoscMglaSolna;

    /**
     * @var integer
     *
     * @ORM\Column(name="odpornosc_parawodna", type="integer", nullable=true)
     */
    private $odpornoscParaWodna;

    /**
     * @var integer
     *
     * @ORM\Column(name="przyczepnosc", type="integer", nullable=true)
     */
    private $przyczepnosc;

    /**
     * @var integer
     *
     * @ORM\Column(name="odpornosc_ogniowa", type="integer", nullable=true)
     */
    private $odpornoscOgien;

    /**
     * @var integer
     *
     * @ORM\Column(name="odpornosc_korozyjna", type="integer", nullable=true)
     */
    private $odpornoscKorozja;

    /**
     * @var integer
     *
     * @ORM\Column(name="odpornosc_uv", type="integer", nullable=true)
     */
    private $odpornoscUV;

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
     * Set wlasciwosciMechaniczne
     *
     * @param string $wlasciwosciMechaniczne
     * @param int $jednostka
     * @return CechyTechniczneProduktu
     */
    public function setWlasciwosciMechaniczne($wlasciwosciMechaniczne, $jednostka = 0)
    {
        if($jednostka == 1)
        {
            $wlasciwosciMechaniczne = $wlasciwosciMechaniczne * 24;
            $this->wlasciwosciMechaniczne = round($wlasciwosciMechaniczne);
        }else{
            $this->wlasciwosciMechaniczne = round($wlasciwosciMechaniczne);
        }

        return $this;
    }

    /**
     * Get wlasciwosciMechaniczne
     *
     * @return string 
     */
    public function getWlasciwosciMechaniczne()
    {
        return $this->wlasciwosciMechaniczne;
    }

    /**
     * Set testErichsen
     *
     * @param string $testErichsen
     * @return CechyTechniczneProduktu
     */
    public function setTestErichsen($testErichsen)
    {
        $this->testErichsen = $testErichsen;

        return $this;
    }

    /**
     * Get testErichsen
     *
     * @return string 
     */
    public function getTestErichsen()
    {
        return $this->testErichsen;
    }

    /**
     * Set udarnosc
     *
     * @param string $udarnosc
     * @return CechyTechniczneProduktu
     */
    public function setUdarnosc($udarnosc)
    {
        $this->udarnosc = $udarnosc;

        return $this;
    }

    /**
     * Get udarnosc
     *
     * @return string 
     */
    public function getUdarnosc()
    {
        return $this->udarnosc;
    }

    /**
     * Set probaMandrela
     *
     * @param string $probaMandrela
     * @return CechyTechniczneProduktu
     */
    public function setProbaMandrela($probaMandrela)
    {
        $this->probaMandrela = $probaMandrela;

        return $this;
    }

    /**
     * Get probaMandrela
     *
     * @return string 
     */
    public function getProbaMandrela()
    {
        return $this->probaMandrela;
    }

    /**
     * Set plastycznosc
     *
     * @param string $plastycznosc
     * @return CechyTechniczneProduktu
     */
    public function setPlastycznosc($plastycznosc)
    {
        $this->plastycznosc = $plastycznosc;

        return $this;
    }

    /**
     * Get plastycznosc
     *
     * @return string 
     */
    public function getPlastycznosc()
    {
        return $this->plastycznosc;
    }

    /**
     * Set odpornoscScieranie
     *
     * @param string $odpornoscScieranie
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscScieranie($odpornoscScieranie)
    {
        $this->odpornoscScieranie = $odpornoscScieranie;

        return $this;
    }

    /**
     * Get odpornoscScieranie
     *
     * @return string 
     */
    public function getOdpornoscScieranie()
    {
        return $this->odpornoscScieranie;
    }

    /**
     * Set odpornoscMedia
     *
     * @param string $odpornoscMedia
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscMedia($odpornoscMedia)
    {
        $this->odpornoscMedia = $odpornoscMedia;

        return $this;
    }

    /**
     * Get odpornoscMedia
     *
     * @return string 
     */
    public function getOdpornoscMedia()
    {
        return $this->odpornoscMedia;
    }

    /**
     * Set odpornoscMglaSolna
     *
     * @param string $odpornoscMglaSolna
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscMglaSolna($odpornoscMglaSolna)
    {
        $this->odpornoscMglaSolna = $odpornoscMglaSolna;

        return $this;
    }

    /**
     * Get odpornoscMglaSolna
     *
     * @return string 
     */
    public function getOdpornoscMglaSolna()
    {
        return $this->odpornoscMglaSolna;
    }

    /**
     * Set odpornoscParaWodna
     *
     * @param string $odpornoscParaWodna
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscParaWodna($odpornoscParaWodna)
    {
        $this->odpornoscParaWodna = $odpornoscParaWodna;

        return $this;
    }

    /**
     * Get odpornoscParaWodna
     *
     * @return string 
     */
    public function getOdpornoscParaWodna()
    {
        return $this->odpornoscParaWodna;
    }

    /**
     * Set przyczepnosc
     *
     * @param string $przyczepnosc
     * @return CechyTechniczneProduktu
     */
    public function setPrzyczepnosc($przyczepnosc)
    {
        $this->przyczepnosc = $przyczepnosc;

        return $this;
    }

    /**
     * Get przyczepnosc
     *
     * @return string 
     */
    public function getPrzyczepnosc()
    {
        return $this->przyczepnosc;
    }

    /**
     * Set odpornoscOgien
     *
     * @param string $odpornoscOgien
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscOgien($odpornoscOgien)
    {
        $this->odpornoscOgien = $odpornoscOgien;

        return $this;
    }

    /**
     * Get odpornoscOgien
     *
     * @return string 
     */
    public function getOdpornoscOgien()
    {
        return $this->odpornoscOgien;
    }

    /**
     * Set odpornoscKorozja
     *
     * @param string $odpornoscKorozja
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscKorozja($odpornoscKorozja)
    {
        $this->odpornoscKorozja = $odpornoscKorozja;

        return $this;
    }

    /**
     * Get odpornoscKorozja
     *
     * @return string 
     */
    public function getOdpornoscKorozja()
    {
        return $this->odpornoscKorozja;
    }

    /**
     * Set odpornoscUV
     *
     * @param string $odpornoscUV
     * @return CechyTechniczneProduktu
     */
    public function setOdpornoscUV($odpornoscUV)
    {
        $this->odpornoscUV = $odpornoscUV;

        return $this;
    }

    /**
     * Get odpornoscUV
     *
     * @return string 
     */
    public function getOdpornoscUV()
    {
        return $this->odpornoscUV;
    }
}
