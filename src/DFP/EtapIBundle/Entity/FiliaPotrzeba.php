<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaPotrzeba
 *
 * @ORM\Table(name="potrzeby_filii")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaPotrzebaRepository")
 */
class FiliaPotrzeba
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
     * @ORM\Column(name="temat", type="string", length=255)
     */
    private $temat;

    /**
     * @var string
     *
     * @ORM\Column(name="opis", type="text")
     */
    private $opis;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=60)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="komentarz", type="text")
     */
    private $komentarz;


    public function __toString()
    {
        return (string) $this->getTemat();
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
     * Set temat
     *
     * @param string $temat
     * @return FiliaPotrzeba
     */
    public function setTemat($temat)
    {
        $this->temat = $temat;
    
        return $this;
    }

    /**
     * Get temat
     *
     * @return string 
     */
    public function getTemat()
    {
        return $this->temat;
    }

    /**
     * Set opis
     *
     * @param string $opis
     * @return FiliaPotrzeba
     */
    public function setOpis($opis)
    {
        $this->opis = $opis;
    
        return $this;
    }

    /**
     * Get opis
     *
     * @return string 
     */
    public function getOpis()
    {
        return $this->opis;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return FiliaPotrzeba
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set komentarz
     *
     * @param string $komentarz
     * @return FiliaPotrzeba
     */
    public function setKomentarz($komentarz)
    {
        $this->komentarz = $komentarz;
    
        return $this;
    }

    /**
     * Get komentarz
     *
     * @return string 
     */
    public function getKomentarz()
    {
        return $this->komentarz;
    }
}
