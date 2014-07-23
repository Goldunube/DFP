<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharakterystykaProduktu
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class CharakterystykaProduktu
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
     * @ORM\Column(name="wydajnoscTeoretyczna", type="string", length=255)
     */
    private $wydajnoscTeoretyczna;

    /**
     * @var string
     *
     * @ORM\Column(name="zuzycieTeoretyczne", type="string", length=255)
     */
    private $zuzycieTeoretyczne;

    /**
     * @var string
     *
     * @ORM\Column(name="wydajnoscPraktyczna", type="string", length=255)
     */
    private $wydajnoscPraktyczna;

    /**
     * @var string
     *
     * @ORM\Column(name="zuzyciePraktyczne", type="string", length=255)
     */
    private $zuzyciePraktyczne;

    /**
     * @var integer
     *
     * @ORM\Column(name="polyskPodKatem", type="integer")
     */
    private $polyskPodKatem;

    /**
     * @var integer
     *
     * @ORM\Column(name="czasDoPrzelakierowania", type="integer")
     */
    private $czasDoPrzelakierowania;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text")
     */
    private $uwagi;


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
     * Set wydajnoscTeoretyczna
     *
     * @param string $wydajnoscTeoretyczna
     * @return CharakterystykaProduktu
     */
    public function setWydajnoscTeoretyczna($wydajnoscTeoretyczna)
    {
        $this->wydajnoscTeoretyczna = $wydajnoscTeoretyczna;

        return $this;
    }

    /**
     * Get wydajnoscTeoretyczna
     *
     * @return string 
     */
    public function getWydajnoscTeoretyczna()
    {
        return $this->wydajnoscTeoretyczna;
    }

    /**
     * Set zuzycieTeoretyczne
     *
     * @param string $zuzycieTeoretyczne
     * @return CharakterystykaProduktu
     */
    public function setZuzycieTeoretyczne($zuzycieTeoretyczne)
    {
        $this->zuzycieTeoretyczne = $zuzycieTeoretyczne;

        return $this;
    }

    /**
     * Get zuzycieTeoretyczne
     *
     * @return string 
     */
    public function getZuzycieTeoretyczne()
    {
        return $this->zuzycieTeoretyczne;
    }

    /**
     * Set wydajnoscPraktyczna
     *
     * @param string $wydajnoscPraktyczna
     * @return CharakterystykaProduktu
     */
    public function setWydajnoscPraktyczna($wydajnoscPraktyczna)
    {
        $this->wydajnoscPraktyczna = $wydajnoscPraktyczna;

        return $this;
    }

    /**
     * Get wydajnoscPraktyczna
     *
     * @return string 
     */
    public function getWydajnoscPraktyczna()
    {
        return $this->wydajnoscPraktyczna;
    }

    /**
     * Set zuzyciePraktyczne
     *
     * @param string $zuzyciePraktyczne
     * @return CharakterystykaProduktu
     */
    public function setZuzyciePraktyczne($zuzyciePraktyczne)
    {
        $this->zuzyciePraktyczne = $zuzyciePraktyczne;

        return $this;
    }

    /**
     * Get zuzyciePraktyczne
     *
     * @return string 
     */
    public function getZuzyciePraktyczne()
    {
        return $this->zuzyciePraktyczne;
    }

    /**
     * Set polyskPodKatem
     *
     * @param integer $polyskPodKatem
     * @return CharakterystykaProduktu
     */
    public function setPolyskPodKatem($polyskPodKatem)
    {
        $this->polyskPodKatem = $polyskPodKatem;

        return $this;
    }

    /**
     * Get polyskPodKatem
     *
     * @return integer 
     */
    public function getPolyskPodKatem()
    {
        return $this->polyskPodKatem;
    }

    /**
     * Set czasDoPrzelakierowania
     *
     * @param integer $czasDoPrzelakierowania
     * @return CharakterystykaProduktu
     */
    public function setCzasDoPrzelakierowania($czasDoPrzelakierowania)
    {
        $this->czasDoPrzelakierowania = $czasDoPrzelakierowania;

        return $this;
    }

    /**
     * Get czasDoPrzelakierowania
     *
     * @return integer 
     */
    public function getCzasDoPrzelakierowania()
    {
        return $this->czasDoPrzelakierowania;
    }

    /**
     * Set uwagi
     *
     * @param string $uwagi
     * @return CharakterystykaProduktu
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
}
