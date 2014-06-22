<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * SystemMalarski
 *
 * @ORM\Table(name="systemy_malarskie")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\SystemMalarskiRepository")
 */
class SystemMalarski
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
     * @ORM\Column(name="komentarz", type="text", nullable=true)
     */
    private $komentarz;

    /**
     * @ORM\ManyToMany(targetEntity="Produkt", inversedBy="systemyMalarskie")
     * @ORM\JoinTable(name="systemymalarskie_produkty",
     *      joinColumns={@ORM\JoinColumn(name="system_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="produkt_id", referencedColumnName="id")}
     * )
     */
    protected $produkty;

    /**
     * @var integer
     *
     * @ORM\OneToMany(targetEntity="ProfilSystem", mappedBy="systemMalarski", cascade={"persist"}, orphanRemoval=true)
     */
    private $profileSystemy;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produkty = new ArrayCollection();
        $this->profileSystemy= new ArrayCollection();
    }

    public function __toString()
    {
        $produkty = $this->getProdukty()->toArray();
        return (string) implode('; ',$produkty);
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
     * Set komentarz
     *
     * @param string $komentarz
     * @return SystemMalarski
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

    /**
     * Add produkty
     *
     * @param Produkt $produkt
     * @return SystemMalarski
     */
    public function addProdukty(Produkt $produkt)
    {
        if(false === $this->produkty->contains($produkt))
        {
            $this->produkty->add($produkt);
//            $this->produkty[] = $produkt;
        }

        return $this;
    }

    /**
     * Remove produkty
     *
     * @param Produkt $produkty
     */
    public function removeProdukty(Produkt $produkty)
    {
        $this->produkty->removeElement($produkty);
    }

    /**
     * Get produkty
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProdukty()
    {
        return $this->produkty;
    }

    /**
     * Add profileSystemy
     *
     * @param ProfilSystem $profileSystemy
     * @return SystemMalarski
     */
    public function addProfileSystemy(ProfilSystem $profileSystemy)
    {
        $this->profileSystemy[] = $profileSystemy;
    
        return $this;
    }

    /**
     * Remove profileSystemy
     *
     * @param ProfilSystem $profileSystemy
     */
    public function removeProfileSystemy(ProfilSystem $profileSystemy)
    {
        $this->profileSystemy->removeElement($profileSystemy);
    }

    /**
     * Get profileSystemy
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProfileSystemy()
    {
        return $this->profileSystemy;
    }
}