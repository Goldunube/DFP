<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaProcesUtwardzaniaPowloki
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FiliaProcesUtwardzaniaPowloki
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
     * @ORM\Column(name="tempMin", type="integer")
     */
    private $tempMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="tempMax", type="integer")
     */
    private $tempMax;

    /**
     * @var string
     *
     * @ORM\Column(name="czasSchniecia", type="string", length=5)
     */
    private $czasSchniecia;


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
     * Set zakresTempMin
     *
     * @param integer $zakresTempMin
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setZakresTempMin($zakresTempMin)
    {
        $this->zakresTempMin = $zakresTempMin;
    
        return $this;
    }

    /**
     * Get zakresTempMin
     *
     * @return integer 
     */
    public function getZakresTempMin()
    {
        return $this->zakresTempMin;
    }

    /**
     * Set zakresTempMax
     *
     * @param integer $zakresTempMax
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setZakresTempMax($zakresTempMax)
    {
        $this->zakresTempMax = $zakresTempMax;
    
        return $this;
    }

    /**
     * Get zakresTempMax
     *
     * @return integer 
     */
    public function getZakresTempMax()
    {
        return $this->zakresTempMax;
    }

    /**
     * Set czasSchniecia
     *
     * @param string $czasSchniecia
     * @return FiliaProcesUtwardzaniaPowloki
     */
    public function setCzasSchniecia($czasSchniecia)
    {
        $this->czasSchniecia = $czasSchniecia;
    
        return $this;
    }

    /**
     * Get czasSchniecia
     *
     * @return string 
     */
    public function getCzasSchniecia()
    {
        return $this->czasSchniecia;
    }
}
