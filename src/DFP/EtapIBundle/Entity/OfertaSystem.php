<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OfertaSystem
 *
 * @ORM\Table(name="oferty_systemy")
 * @ORM\Entity
 */
class OfertaSystem
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
     * @var array
     * @ORM\Column(name="warstwa_1", type="array")
     */
    private $warstwa1;

    /**
     * @var array
     * @ORM\Column(name="warstwa_2", type="array")
     */
    private $warstwa2;

    /**
     * @var array
     * @ORM\Column(name="warstwa_3", type="array")
     */
    private $warstwa3;

    /**
     * @var array
     * @ORM\Column(name="warstwa_4", type="array")
     */
    private $warstwa4;

    /**
     * @var string
     *
     * @ORM\Column(name="informacja", type="text")
     */
    private $informacja;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\OfertaHandlowa", inversedBy="ofertySystemy")
     * @ORM\JoinColumn(name="oferta_id")
     */
    private $oferta;

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\ProfilDzialalnosci")
     * @ORM\JoinColumn(name="profil_id")
     */
    private $profil;

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
     * Set informacja
     *
     * @param string $informacja
     * @return OfertaSystem
     */
    public function setInformacja($informacja)
    {
        $this->informacja = $informacja;

        return $this;
    }

    /**
     * Get informacja
     *
     * @return string 
     */
    public function getInformacja()
    {
        return $this->informacja;
    }

    /**
     * Set oferta
     *
     * @param OfertaHandlowa $oferta
     * @return OfertaSystem
     */
    public function setOferta(OfertaHandlowa $oferta = null)
    {
        $this->oferta = $oferta;

        return $this;
    }

    /**
     * Get oferta
     *
     * @return OfertaHandlowa
     */
    public function getOferta()
    {
        return $this->oferta;
    }

    /**
     * Set profil
     *
     * @param ProfilDzialalnosci $profil
     * @return OfertaSystem
     */
    public function setProfil(ProfilDzialalnosci $profil = null)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return ProfilDzialalnosci
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * @return array
     */
    public function getWarstwa1()
    {
        return $this->warstwa1;
    }

    /**
     * @param array $warstwa1
     */
    public function setWarstwa1($warstwa1)
    {
        $this->warstwa1 = $warstwa1;
    }

    /**
     * @return mixed
     */
    public function getWarstwa2()
    {
        return $this->warstwa2;
    }

    /**
     * @param mixed $warstwa2
     */
    public function setWarstwa2($warstwa2)
    {
        $this->warstwa2 = $warstwa2;
    }

    /**
     * @return mixed
     */
    public function getWarstwa3()
    {
        return $this->warstwa3;
    }

    /**
     * @param mixed $warstwa3
     */
    public function setWarstwa3($warstwa3)
    {
        $this->warstwa3 = $warstwa3;
    }

    /**
     * @return mixed
     */
    public function getWarstwa4()
    {
        return $this->warstwa4;
    }

    /**
     * @param mixed $warstwa4
     */
    public function setWarstwa4($warstwa4)
    {
        $this->warstwa4 = $warstwa4;
    }
}
