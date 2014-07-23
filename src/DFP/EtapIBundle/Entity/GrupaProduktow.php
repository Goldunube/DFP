<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OrderBy;

/**
 * GrupaProduktow
 *
 * @ORM\Table(name="grupy_produktow")
 * @ORM\Entity
 */
class GrupaProduktow
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
     * @ORM\Column(name="nazwa", type="string", length=55)
     * @OrderBy({"nazwa" = "ASC"})
     */
    private $nazwa;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="DFP\EtapIBundle\Entity\Produkt", mappedBy="grupaProduktow")
     */
    private $produkty;


    /**
     * To String
     */
    public function __toString()
    {
        return (string) $this->getNazwa();
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
     * Set nazwa
     *
     * @param string $nazwa
     * @return GrupaProduktow
     */
    public function setNazwa($nazwa)
    {
        $this->nazwa = $nazwa;

        return $this;
    }

    /**
     * Get nazwa
     *
     * @return string 
     */
    public function getNazwa()
    {
        return $this->nazwa;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produkty = new ArrayCollection();
    }

    /**
     * Add produkty
     *
     * @param Produkt $produkty
     * @return GrupaProduktow
     */
    public function addProdukty(Produkt $produkty)
    {
        $this->produkty[] = $produkty;

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
}
