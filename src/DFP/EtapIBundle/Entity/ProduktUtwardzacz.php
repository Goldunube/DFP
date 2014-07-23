<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduktUtwardzacz
 *
 * @ORM\Table(name="produkty_utwardzacze")
 * @ORM\Entity
 */
class ProduktUtwardzacz
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
     * @var array
     *
     * @ORM\Column(name="proporcja_mieszania_objetosciowo", type="array", nullable=true)
     */
    private $proporcjaMieszaniaObjetosciowo;

    /**
     * @var array
     *
     * @ORM\Column(name="proporcja_mieszani_wWagowo", type="array", nullable=true)
     */
    private $proporcjaMieszaniaWagowo;

    /**
     * @ORM\ManyToOne(targetEntity="PrzygotowanieDoAplikacji", inversedBy="produktyUtwardzacze")
     */
    private $produkt;

    /**
     * @ORM\ManyToOne(targetEntity="Produkt", inversedBy="produktyUtwardzacze")
     */
    private $utwardzacz;


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
     * Set proporcjaMieszaniaObjetosciowo
     *
     * @param string $proporcjaMieszaniaObjetosciowo
     * @return ProduktUtwardzacz
     */
    public function setProporcjaMieszaniaObjetosciowo($proporcjaMieszaniaObjetosciowo)
    {
        $this->proporcjaMieszaniaObjetosciowo = $proporcjaMieszaniaObjetosciowo;

        return $this;
    }

    /**
     * Get proporcjaMieszaniaObjetosciowo
     *
     * @return string 
     */
    public function getProporcjaMieszaniaObjetosciowo()
    {
        return $this->proporcjaMieszaniaObjetosciowo;
    }

    /**
     * Set proporcjaMieszaniaWagowo
     *
     * @param string $proporcjaMieszaniaWagowo
     * @return ProduktUtwardzacz
     */
    public function setProporcjaMieszaniaWagowo($proporcjaMieszaniaWagowo)
    {
        $this->proporcjaMieszaniaWagowo = $proporcjaMieszaniaWagowo;

        return $this;
    }

    /**
     * Get proporcjaMieszaniaWagowo
     *
     * @return string 
     */
    public function getProporcjaMieszaniaWagowo()
    {
        return $this->proporcjaMieszaniaWagowo;
    }

    /**
     * Set produkt
     *
     * @param PrzygotowanieDoAplikacji $produkt
     * @return ProduktUtwardzacz
     */
    public function setProdukt(PrzygotowanieDoAplikacji $produkt = null)
    {
        $this->produkt = $produkt;

        return $this;
    }

    /**
     * Get produkt
     *
     * @return PrzygotowanieDoAplikacji
     */
    public function getProdukt()
    {
        return $this->produkt;
    }

    /**
     * Set utwardzacz
     *
     * @param Produkt $utwardzacz
     * @return ProduktUtwardzacz
     */
    public function setUtwardzacz(Produkt $utwardzacz = null)
    {
        $this->utwardzacz = $utwardzacz;

        return $this;
    }

    /**
     * Get utwardzacz
     *
     * @return Produkt
     */
    public function getUtwardzacz()
    {
        return $this->utwardzacz;
    }
}
