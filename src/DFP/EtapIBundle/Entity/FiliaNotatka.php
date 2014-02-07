<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaNotatka
 *
 * @ORM\Table(name="notatki_filii")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaNotatkaRepository")
 */
class FiliaNotatka
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
     * @ORM\Column(name="tresc", type="text")
     */
    private $tresc;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="data_sporzadzenia", type="datetime")
     */
    private $dataSporzadzenia;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="koniecEdycji", type="datetime")
     */
    private $koniecEdycji;


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
     * Set tresc
     *
     * @param string $tresc
     * @return FiliaNotatka
     */
    public function setTresc($tresc)
    {
        $this->tresc = $tresc;
    
        return $this;
    }

    /**
     * Get tresc
     *
     * @return string 
     */
    public function getTresc()
    {
        return $this->tresc;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return FiliaNotatka
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set sporzadzona
     *
     * @param \DateTime $sporzadzona
     * @return FiliaNotatka
     */
    public function setSporzadzona($sporzadzona)
    {
        $this->sporzadzona = $sporzadzona;
    
        return $this;
    }

    /**
     * Get sporzadzona
     *
     * @return \DateTime 
     */
    public function getSporzadzona()
    {
        return $this->sporzadzona;
    }

    /**
     * Set koniecEdycji
     *
     * @param \DateTime $koniecEdycji
     * @return FiliaNotatka
     */
    public function setKoniecEdycji($koniecEdycji)
    {
        $this->koniecEdycji = $koniecEdycji;
    
        return $this;
    }

    /**
     * Get koniecEdycji
     *
     * @return \DateTime 
     */
    public function getKoniecEdycji()
    {
        return $this->koniecEdycji;
    }
}
