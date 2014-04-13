<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaMaterialUzupelniajacy
 *
 * @ORM\Table(name="filie_materialy_uzupelniajace")
 * @ORM\Entity
 */
class FiliaMaterialUzupelniajacy
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
     * @ORM\Column(name="info", type="string", length=255, nullable=true)
     */
    private $info;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Filia", inversedBy="filieMaterialyUzupelniajace")
     * @ORM\JoinColumn(name="filia_id", referencedColumnName="id", nullable=false)
     */
    private $filia;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="MaterialUzupelniajacy", inversedBy="filieMaterialyUzupelniajace")
     * @ORM\JoinColumn(name="material_uzupelniajacy_id", referencedColumnName="id", nullable=false)
     */
    private $materialUzupelniajacy;


    /**
     * To String
     *
     * @return string
     */
    public function __toString()
    {
        return (string) '<span title="'.$this->getInfo().'">'.$this->getMaterialUzupelniajacy().'</span>';
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
     * Set info
     *
     * @param string $info
     * @return FiliaMaterialUzupelniajacy
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
     * @return FiliaMaterialUzupelniajacy
     */
    public function setFilia(Filia $filia)
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
     * Set materialUzupelniajacy
     *
     * @param MaterialUzupelniajacy $materialUzupelniajacy
     * @return FiliaMaterialUzupelniajacy
     */
    public function setMaterialUzupelniajacy(MaterialUzupelniajacy $materialUzupelniajacy)
    {
        $this->materialUzupelniajacy = $materialUzupelniajacy;
    
        return $this;
    }

    /**
     * Get materialUzupelniajacy
     *
     * @return MaterialUzupelniajacy
     */
    public function getMaterialUzupelniajacy()
    {
        return $this->materialUzupelniajacy;
    }
}