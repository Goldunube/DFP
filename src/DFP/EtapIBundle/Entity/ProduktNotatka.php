<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Blameable;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProduktNotatka
 *
 * @ORM\Table(name="notatki_do_produktow")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProduktNotatkaRepository")
 */
class ProduktNotatka
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
     * @ORM\Column(name="tresc", type="text", nullable=false)
     * @Assert\NotBlank()
     *
     */
    private $tresc;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = true;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createDate", type="datetime")
     * @Timestampable(on="create")
     */
    private $createDate;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik");
     * @ORM\JoinColumn(nullable=false)
     * @Blameable(on="create")
     */
    private $autor;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modifyDate", type="datetime")
     * @Timestampable(on="update")
     */
    private $modifyDate;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Produkt", inversedBy="notatki")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produkt;


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
     * @return ProduktNotatka
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
     * @param string $status
     * @return ProduktNotatka
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
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return ProduktNotatka
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime 
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set autor
     *
     * @param integer $autor
     * @return ProduktNotatka
     */
    public function setAutor($autor)
    {
        $this->autor = $autor;

        return $this;
    }

    /**
     * Get autor
     *
     * @return integer 
     */
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set modifyDate
     *
     * @param \DateTime $modifyDate
     * @return ProduktNotatka
     */
    public function setModifyDate($modifyDate)
    {
        $this->modifyDate = $modifyDate;

        return $this;
    }

    /**
     * Get modifyDate
     *
     * @return \DateTime 
     */
    public function getModifyDate()
    {
        return $this->modifyDate;
    }

    /**
     * Set produkt
     *
     * @param Produkt $produkt
     * @return ProduktNotatka
     */
    public function setProdukt(Produkt $produkt = null)
    {
        $this->produkt = $produkt;

        return $this;
    }

    /**
     * Get produkt
     *
     * @return Produkt
     */
    public function getProdukt()
    {
        return $this->produkt;
    }
}
