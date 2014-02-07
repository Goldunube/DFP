<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FiliaZobowiazanie
 *
 * @ORM\Table(name="zobowiazania_filii")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\FiliaZobowiazanieRepository")
 */
class FiliaZobowiazanie
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
     * @ORM\Column(name="notatka", type="text")
     */
    private $notatka;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deadline", type="datetime")
     */
    private $deadline;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=60)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="strona_zobowiazania", type="string", length=25)
     */
    private $stronaZobowiazania;


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
     * @return FiliaZobowiazanie
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
     * Set notatka
     *
     * @param string $notatka
     * @return FiliaZobowiazanie
     */
    public function setNotatka($notatka)
    {
        $this->notatka = $notatka;
    
        return $this;
    }

    /**
     * Get notatka
     *
     * @return string 
     */
    public function getNotatka()
    {
        return $this->notatka;
    }

    /**
     * Set deadline
     *
     * @param \DateTime $deadline
     * @return FiliaZobowiazanie
     */
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    
        return $this;
    }

    /**
     * Get deadline
     *
     * @return \DateTime 
     */
    public function getDeadline()
    {
        return $this->deadline;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return FiliaZobowiazanie
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
}
