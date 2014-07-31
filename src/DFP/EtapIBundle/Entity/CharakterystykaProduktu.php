<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

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
     * @var integer
     *
     * @ORM\Column(name="polysk_pod_katem", type="integer", nullable=true)
     */
    private $polyskPodKatem;

    /**
     * @var integer
     *
     * @ORM\Column(name="czas_do_przelakierowania_min", type="integer", nullable=true)
     */
    private $czasDoPrzelakierowaniaMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="czas_do_przelakierowania_max", type="integer", nullable=true)
     */
    private $czasDoPrzelakierowaniaMax;

    /**
     * @var string
     *
     * @ORM\Column(name="uwagi", type="text", nullable=true)
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
     * Set czasDoPrzelakierowaniaMin
     *
     * @param integer $czasDoPrzelakierowaniaMin
     * @return CharakterystykaProduktu
     */
    public function setCzasDoPrzelakierowaniaMin($czasDoPrzelakierowaniaMin)
    {
        $this->czasDoPrzelakierowaniaMin = $czasDoPrzelakierowaniaMin;

        return $this;
    }

    /**
     * Get czasDoPrzelakierowaniaMin
     *
     * @return integer
     */
    public function getCzasDoPrzelakierowaniaMin()
    {
        return $this->czasDoPrzelakierowaniaMin;
    }

    /**
     * Set czasDoPrzelakierowaniaMax
     *
     * @param integer $czasDoPrzelakierowaniaMax
     * @return CharakterystykaProduktu
     */
    public function setCzasDoPrzelakierowaniaMax($czasDoPrzelakierowaniaMax)
    {
        $this->czasDoPrzelakierowaniaMax = $czasDoPrzelakierowaniaMax;

        return $this;
    }

    /**
     * Get czasDoPrzelakierowaniaMax
     *
     * @return integer
     */
    public function getCzasDoPrzelakierowaniaMax()
    {
        return $this->czasDoPrzelakierowaniaMax;
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
