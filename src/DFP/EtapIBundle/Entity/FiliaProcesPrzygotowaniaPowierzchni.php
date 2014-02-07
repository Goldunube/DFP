<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaProcesPrzygotowaniaPowierzchni
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class FiliaProcesPrzygotowaniaPowierzchni
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
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieProcesyPrzygotowaniaPowierzchni")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id")
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="ProcesPrzygotowaniaPowierzchni", inversedBy="filieProcesyPrzygotowaniaPowierzchni")
     * @ORM\JoinColumn(name="proces_id", referencedColumnName="id")
     */
    private $procesPrzygotowaniaPowierzchni;


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
     * Set opis
     *
     * @param string $opis
     * @return FiliaProcesPrzygotowaniaPowierzchni
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
}
