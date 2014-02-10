<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaWymaganiaProduktu
 *
 * @ORM\Table(name="filie_wymagania_produktow")
 * @ORM\Entity
 */
class FiliaWymaganiaProduktu
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
     * @ORM\Column(name="info", type="string", length=255)
     */
    private $info;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieWymaganiaProduktow")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id")
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="WymaganiaProduktu", inversedBy="filieWymaganiaProduktow")
     * @ORM\JoinColumn(name="wymagania_produktu_id", referencedColumnName="id")
     */
    private $wymaganiaProduktu;


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
     * Set info
     *
     * @param string $info
     * @return FiliaWymaganiaProduktu
     */
    public function setInfo($info)
    {
        $this->info = $info;
    
        return $this;
    }

    /**
     * Get info
     *
     * @return string 
     */
    public function getInfo()
    {
        return $this->info;
    }

    /**
     * Set filia
     *
     * @param Filia $filia
     * @return FiliaWymaganiaProduktu
     */
    public function setFilia(Filia $filia = null)
    {
        $this->filia = $filia;
    
        return $this;
    }

    /**
     * Get filia
     *
     * @return Filia
     */
    public function getFilia()
    {
        return $this->filia;
    }

    /**
     * Set wymaganiaProduktu
     *
     * @param Filia $wymaganiaProduktu
     * @return FiliaWymaganiaProduktu
     */
    public function setWymaganiaProduktu(Filia $wymaganiaProduktu = null)
    {
        $this->wymaganiaProduktu = $wymaganiaProduktu;
    
        return $this;
    }

    /**
     * Get wymaganiaProduktu
     *
     * @return Filia
     */
    public function getWymaganiaProduktu()
    {
        return $this->wymaganiaProduktu;
    }
}