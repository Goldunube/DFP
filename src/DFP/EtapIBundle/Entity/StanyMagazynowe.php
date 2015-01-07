<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StanyMagazynowe
 *
 * @ORM\Table(name="stany_magazynowe_2p")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\StanyMagazynoweRepository")
 */
class StanyMagazynowe
{
    /**
     * @var string
     *
     * @ORM\Column(name="indeks", type="string", length=50)
     * @ORM\Id
     */
    private $indeks;

    /**
     * @var string
     *
     * @ORM\Column(name="nazwa", type="string", length=200)
     */
    private $nazwa;

    /**
     * @var string
     *
     * @ORM\Column(name="ilosc", type="decimal", precision=22, scale=4)
     */
    private $ilosc;

    /**
     * @var string
     *
     * @ORM\Column(name="jm", type="string", length=10)
     */
    private $jm;


    /**
     * Set indeks
     *
     * @param string $indeks
     * @return StanyMagazynowe
     */
    public function setIndeks($indeks)
    {
        $this->indeks = $indeks;

        return $this;
    }

    /**
     * Get indeks
     *
     * @return string 
     */
    public function getIndeks()
    {
        return $this->indeks;
    }

    /**
     * Set nazwa
     *
     * @param string $nazwa
     * @return StanyMagazynowe
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }

    /**
     * Set ilosc
     *
     * @param string $ilosc
     * @return StanyMagazynowe
     */
    public function setIlosc($ilosc)
    {
        $this->ilosc = $ilosc;

        return $this;
    }

    /**
     * Get ilosc
     *
     * @return string 
     */
    public function getIlosc()
    {
        return $this->ilosc;
    }

    /**
     * Set jm
     *
     * @param string $jm
     * @return StanyMagazynowe
     */
    public function setJm($jm)
    {
        $this->jm = $jm;

        return $this;
    }

    /**
     * Get jm
     *
     * @return string 
     */
    public function getJm()
    {
        return $this->jm;
    }
}
