<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProduktRozcienczalnik
 *
 * @ORM\Table(name="produkty_rozcienczalniki")
 * @ORM\Entity
 */
class ProduktRozcienczalnik
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
     * @ORM\Column(name="proporcja_mieszania", type="string", length=7, nullable=true)
     */
    private $proporcjaMieszania;

    /**
     * @ORM\ManyToOne(targetEntity="PrzygotowanieDoAplikacji", inversedBy="produktyRozcienczalniki")
     */
    private $przygotowanie;

    /**
     * @ORM\ManyToOne(targetEntity="Produkt", inversedBy="produktyRozcienczalniki")
     */
    private $rozcienczalnik;


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
     * Set proporcjaMieszania
     *
     * @param array $proporcjaMieszania
     * @return ProduktRozcienczalnik
     */
    public function setProporcjaMieszania($proporcjaMieszania)
    {
        $this->proporcjaMieszania = $proporcjaMieszania;

        return $this;
    }

    /**
     * Get proporcjaMieszania
     *
     * @return array 
     */
    public function getProporcjaMieszania()
    {
        return $this->proporcjaMieszania;
    }

    /**
     * Set przygotowanie
     *
     * @param PrzygotowanieDoAplikacji $przygotowanie
     * @return ProduktRozcienczalnik
     */
    public function setPrzygotowanie(PrzygotowanieDoAplikacji $przygotowanie = null)
    {
        $this->przygotowanie = $przygotowanie;

        return $this;
    }

    /**
     * Get przygotowanie
     *
     * @return PrzygotowanieDoAplikacji
     */
    public function getPrzygotowanie()
    {
        return $this->przygotowanie;
    }

    /**
     * Set rozcienczalnik
     *
     * @param Produkt $rozcienczalnik
     * @return ProduktRozcienczalnik
     */
    public function setRozcienczalnik(Produkt $rozcienczalnik = null)
    {
        $this->rozcienczalnik = $rozcienczalnik;

        return $this;
    }

    /**
     * Get rozcienczalnik
     *
     * @return Produkt
     */
    public function getRozcienczalnik()
    {
        return $this->rozcienczalnik;
    }
}
