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
     * @ORM\Column(name="polysk_pod_katem_min", type="integer", nullable=true)
     */
    private $polyskPodKatemMin;

    /**
     * @var integer
     *
     * @ORM\Column(name="polysk_pod_katem_max", type="integer", nullable=true)
     */
    private $polyskPodKatemMax;

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
     * Set polyskPodKatemMin
     *
     * @param integer $polyskPodKatemMin
     * @return CharakterystykaProduktu
     */
    public function setPolyskPodKatemMin($polyskPodKatemMin)
    {
        $this->polyskPodKatemMin = $polyskPodKatemMin;

        return $this;
    }

    /**
     * Get polyskPodKatemMin
     *
     * @return integer 
     */
    public function getPolyskPodKatemMin()
    {
        return $this->polyskPodKatemMin;
    }

    /**
     * Set polyskPodKatemMax
     *
     * @param integer $polyskPodKatemMax
     * @return CharakterystykaProduktu
     */
    public function setPolyskPodKatemMax($polyskPodKatemMax)
    {
        $this->polyskPodKatemMax = $polyskPodKatemMax;

        return $this;
    }

    /**
     * Get polyskPodKatemMax
     *
     * @return integer
     */
    public function getPolyskPodKatemMax()
    {
        return $this->polyskPodKatemMax;
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
