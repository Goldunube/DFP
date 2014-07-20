<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Produkt
 *
 * @ORM\Table(name="produkty")
 * @ORM\Entity(repositoryClass="DFP\EtapIBundle\Entity\ProduktRepository")
 */
class Produkt
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
     * @ORM\Column(name="nazwa_handlowa", type="string", length=255)
     */
    private $nazwaHandlowa;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", nullable=true)
     */
    private $uwagi;

    /**
     * Parametr określający przynależność produktu do grupy promowania. Grupa promowania determinuje kolejność wyświetlania produktu.
     *
     * @var integer
     *
     * @ORM\Column(name="grupa_promowania")
     */
    private $grupaPromowania = 0;

    /**
     * @ORM\ManyToMany(targetEntity="SystemMalarski", mappedBy="produkty")
     *
     */
    private $systemyMalarskie;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\GrupaProduktow", inversedBy="produkty")
     */
    private $grupaProduktow;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->systemyMalarskie = new ArrayCollection();
    }

    /**
     * To String
     */
    public function __toString()
    {
        return (string) $this->getNazwaHandlowa();
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
     * Set Nazwa Handlowa
     *
     * @param string $nazwaHandlowa
     * @return Produkt
     */
    public function setNazwaHandlowa($nazwaHandlowa)
    {
        $this->nazwaHandlowa = $nazwaHandlowa;
    
        return $this;
    }

    /**
     * Get Nazwa Handlowa
     *
     * @return string 
     */
    public function getNazwaHandlowa()
    {
        return $this->nazwaHandlowa;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     * @return Produkt
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;
    
        return $this;
    }

    /**
     * Get uwagi
     *
     * @return string 
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }

    /**
     * Set Grupa Promowania
     *
     * @param integer $grupaPromowania
     * @return Produkt
     */
    public function setGrupaPromowania($grupaPromowania = 0)
    {
        $this->grupaPromowania = $grupaPromowania;

        return $this;
    }

    /**
     * Get Grupa Promowania
     *
     * @return string
     */
    public function getGrupaPromowania()
    {
        return $this->grupaPromowania;
    }
    
    /**
     * Add systemyMalarskie
     *
     * @param SystemMalarski $systemyMalarskie
     * @return Produkt
     */
    public function addSystemyMalarskie(SystemMalarski $systemyMalarskie)
    {
        $this->systemyMalarskie[] = $systemyMalarskie;
    
        return $this;
    }

    /**
     * Remove systemyMalarskie
     *
     * @param SystemMalarski $systemyMalarskie
     */
    public function removeSystemyMalarskie(SystemMalarski $systemyMalarskie)
    {
        $this->systemyMalarskie->removeElement($systemyMalarskie);
    }

    /**
     * Get systemyMalarskie
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSystemyMalarskie()
    {
        return $this->systemyMalarskie;
    }

    /**
     * Set grupaProduktow
     *
     * @param GrupaProduktow $grupaProduktow
     * @return Produkt
     */
    public function setGrupaProduktow(GrupaProduktow $grupaProduktow = null)
    {
        $this->grupaProduktow = $grupaProduktow;

        return $this;
    }

    /**
     * Get grupaProduktow
     *
     * @return GrupaProduktow
     */
    public function getGrupaProduktow()
    {
        return $this->grupaProduktow;
    }
}
