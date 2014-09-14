<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * PrzygotowanieDoAplikacji
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PrzygotowanieDoAplikacji
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
     * @ORM\OneToMany(targetEntity="ProduktUtwardzacz", mappedBy="produkt", cascade={"persist"}, orphanRemoval=true)
     */
    private $produktyUtwardzacze;

    /**
     * @ORM\OneToMany(targetEntity="ProduktRozcienczalnik", mappedBy="przygotowanie", cascade={"persist"}, orphanRemoval=true)
     */
    private $produktyRozcienczalniki;

    /**
     * @var string
     *
     * @ORM\Column(name="przyspieszacz", type="string", length=255, nullable=true)
     */
    private $przyspieszacz;

    /**
     * @var integer
     *
     * @ORM\Column(name="antygrafiti", type="integer")
     */
    private $antygrafiti = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="pasta_matujaca", type="string", length=255, nullable=true)
     */
    private $pastaMatujaca;

    /**
     * @var string
     *
     * @ORM\Column(name="dodatki", type="string", length=255, nullable=true)
     */
    private $dodatki;

    /**
     * @var string
     *
     * @ORM\Column(name="strukturyzator", type="string", length=255, nullable=true)
     */
    private $strukturyzator;

    /**
     * @var string
     *
     * @ORM\Column(name="tix", type="string", length=255, nullable=true)
     */
    private $tix;

    /**
     * @var integer
     * @ORM\Column(name="zywotnosc_mieszaniny", type="integer", nullable=true)
     */
    private $zywotnoscMieszaniny;

    /**
     * @var string
     * @ORM\Column(name="lepkosc_stomer_min", type="decimal", precision=7, scale=2, nullable=true)
     *
     * @Assert\Type(
     *      type = "numeric",
     *      message = "Wprowadzona przez Ciebie wartość '{{ value }}' nie jest liczbą zmiennoprzecinkową."
     * )
     */
    private $lepkoscStomerMIN;

    /**
     * @var string
     * @ORM\Column(name="lepkosc_stomer_max", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $lepkoscStomerMAX;

    /**
     * @var string
     * @ORM\Column(name="lepkosc_ford_min", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $lepkoscFordMIN;

    /**
     * @var string
     * @ORM\Column(name="lepkosc_form_max", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $lepkoscFordMAX;

    /**
     * @var string
     * @ORM\Column(name="zal_grubosc_pow_sucho_min", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $zalecanaGruboscPowlokiSuchoMin;

    /**
     * @var string
     * @ORM\Column(name="zal_grubosc_pow_sucho_max", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $zalecanaGruboscPowlokiSuchoMax;

    /**
     * @var string
     * @ORM\Column(name="zal_grubosc_pow_mokro_min", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $zalecanaGruboscPowlokiMokroMin;

    /**
     * @var string
     * @ORM\Column(name="nom_grubosc_pow_mokro_max", type="decimal", precision=7, scale=2, nullable=true)
     */
    private $zalecanaGruboscPowlokiMokroMax;

    /**
     * @var boolean
     * @ORM\Column(name="punkt_rosy", type="boolean", nullable=false)
     */
    private $punktRosy = false;

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
     * Set przyspieszacz
     *
     * @param string $przyspieszacz
     * @return PrzygotowanieDoAplikacji
     */
    public function setPrzyspieszacz($przyspieszacz)
    {
        $this->przyspieszacz = $przyspieszacz;

        return $this;
    }

    /**
     * Get przyspieszacz
     *
     * @return string 
     */
    public function getPrzyspieszacz()
    {
        return $this->przyspieszacz;
    }

    /**
     * Set antygrafiti
     *
     * @param boolean $antygrafiti
     * @return PrzygotowanieDoAplikacji
     */
    public function setAntygrafiti($antygrafiti)
    {
        $this->antygrafiti = $antygrafiti;

        return $this;
    }

    /**
     * Get antygrafiti
     *
     * @return boolean 
     */
    public function getAntygrafiti()
    {
        return $this->antygrafiti;
    }

    /**
     * Set pastaMatujaca
     *
     * @param string $pastaMatujaca
     * @return PrzygotowanieDoAplikacji
     */
    public function setPastaMatujaca($pastaMatujaca)
    {
        $this->pastaMatujaca = $pastaMatujaca;

        return $this;
    }

    /**
     * Get pastaMatujaca
     *
     * @return string 
     */
    public function getPastaMatujaca()
    {
        return $this->pastaMatujaca;
    }

    /**
     * Set dodatki
     *
     * @param string $dodatki
     * @return PrzygotowanieDoAplikacji
     */
    public function setDodatki($dodatki)
    {
        $this->dodatki = $dodatki;

        return $this;
    }

    /**
     * Get dodatki
     *
     * @return string 
     */
    public function getDodatki()
    {
        return $this->dodatki;
    }

    /**
     * Set strukturyzator
     *
     * @param string $strukturyzator
     * @return PrzygotowanieDoAplikacji
     */
    public function setStrukturyzator($strukturyzator)
    {
        $this->strukturyzator = $strukturyzator;

        return $this;
    }

    /**
     * Get strukturyzator
     *
     * @return string 
     */
    public function getStrukturyzator()
    {
        return $this->strukturyzator;
    }

    /**
     * Set tix
     *
     * @param string $tix
     * @return PrzygotowanieDoAplikacji
     */
    public function setTix($tix)
    {
        $this->tix = $tix;

        return $this;
    }

    /**
     * Get tix
     *
     * @return string 
     */
    public function getTix()
    {
        return $this->tix;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->produktyUtwardzacze = new ArrayCollection();
        $this->produktyRozcienczalniki = new ArrayCollection();
    }

    /**
     * Set zywotnoscMieszaniny
     *
     * @param integer $zywotnoscMieszaniny
     * @return PrzygotowanieDoAplikacji
     */
    public function setZywotnoscMieszaniny($zywotnoscMieszaniny)
    {
        $this->zywotnoscMieszaniny = $zywotnoscMieszaniny;

        return $this;
    }

    /**
     * Get zywotnoscMieszaniny
     *
     * @return integer 
     */
    public function getZywotnoscMieszaniny()
    {
        return $this->zywotnoscMieszaniny;
    }

    /**
     * Set lepkoscStomerMIN
     *
     * @param string $lepkoscStomerMIN
     * @return PrzygotowanieDoAplikacji
     */
    public function setLepkoscStomerMIN($lepkoscStomerMIN)
    {
        $this->lepkoscStomerMIN = $lepkoscStomerMIN;

        return $this;
    }

    /**
     * Get lepkoscStomerMIN
     *
     * @return string 
     */
    public function getLepkoscStomerMIN()
    {
        return $this->lepkoscStomerMIN;
    }

    /**
     * Set lepkoscStomerMAX
     *
     * @param string $lepkoscStomerMAX
     * @return PrzygotowanieDoAplikacji
     */
    public function setLepkoscStomerMAX($lepkoscStomerMAX)
    {
        $this->lepkoscStomerMAX = $lepkoscStomerMAX;

        return $this;
    }

    /**
     * Get lepkoscStomerMAX
     *
     * @return string 
     */
    public function getLepkoscStomerMAX()
    {
        return $this->lepkoscStomerMAX;
    }

    /**
     * Set lepkoscFordMIN
     *
     * @param string $lepkoscFordMIN
     * @return PrzygotowanieDoAplikacji
     */
    public function setLepkoscFordMIN($lepkoscFordMIN)
    {
        $this->lepkoscFordMIN = $lepkoscFordMIN;

        return $this;
    }

    /**
     * Get lepkoscFordMIN
     *
     * @return string 
     */
    public function getLepkoscFordMIN()
    {
        return $this->lepkoscFordMIN;
    }

    /**
     * Set lepkoscFordMAX
     *
     * @param string $lepkoscFordMAX
     * @return PrzygotowanieDoAplikacji
     */
    public function setLepkoscFordMAX($lepkoscFordMAX)
    {
        $this->lepkoscFordMAX = $lepkoscFordMAX;

        return $this;
    }

    /**
     * Get lepkoscFordMAX
     *
     * @return string 
     */
    public function getLepkoscFordMAX()
    {
        return $this->lepkoscFordMAX;
    }

    /**
     * Set zalecanaGruboscPowlokiSuchoMin
     *
     * @param string $zalecanaGruboscPowlokiSuchoMin
     * @return PrzygotowanieDoAplikacji
     */
    public function setZalecanaGruboscPowlokiSuchoMin($zalecanaGruboscPowlokiSuchoMin)
    {
        $this->zalecanaGruboscPowlokiSuchoMin = $zalecanaGruboscPowlokiSuchoMin;

        return $this;
    }

    /**
     * Get zalecanaGruboscPowlokiSuchoMin
     *
     * @return string 
     */
    public function getZalecanaGruboscPowlokiSuchoMin()
    {
        return $this->zalecanaGruboscPowlokiSuchoMin;
    }

    /**
     * Set zalecanaGruboscPowlokiSuchoMax
     *
     * @param string $zalecanaGruboscPowlokiSuchoMax
     * @return PrzygotowanieDoAplikacji
     */
    public function setZalecanaGruboscPowlokiSuchoMax($zalecanaGruboscPowlokiSuchoMax)
    {
        $this->zalecanaGruboscPowlokiSuchoMax = $zalecanaGruboscPowlokiSuchoMax;

        return $this;
    }

    /**
     * Get zalecanaGruboscPowlokiSuchoMax
     *
     * @return string
     */
    public function getZalecanaGruboscPowlokiSuchoMax()
    {
        return $this->zalecanaGruboscPowlokiSuchoMax;
    }

    /**
     * Set zalecanaGruboscPowlokiMokroMin
     *
     * @param string $zalecanaGruboscPowlokiMokroMin
     * @return PrzygotowanieDoAplikacji
     */
    public function setZalecanaGruboscPowlokiMokroMin($zalecanaGruboscPowlokiMokroMin)
    {
        $this->zalecanaGruboscPowlokiMokroMin = $zalecanaGruboscPowlokiMokroMin;

        return $this;
    }

    /**
     * Get zalecanaGruboscPowlokiMokroMin
     *
     * @return string 
     */
    public function getZalecanaGruboscPowlokiMokroMin()
    {
        return $this->zalecanaGruboscPowlokiMokroMin;
    }

    /**
     * Set zalecanaGruboscPowlokiMokroMax
     *
     * @param string $zalecanaGruboscPowlokiMokroMax
     * @return PrzygotowanieDoAplikacji
     */
    public function setZalecanaGruboscPowlokiMokroMax($zalecanaGruboscPowlokiMokroMax)
    {
        $this->zalecanaGruboscPowlokiMokroMax = $zalecanaGruboscPowlokiMokroMax;

        return $this;
    }

    /**
     * Get zalecanaGruboscPowlokiMokroMax
     *
     * @return string
     */
    public function getZalecanaGruboscPowlokiMokroMax()
    {
        return $this->zalecanaGruboscPowlokiMokroMax;
    }

    /**
     * Set punktRosy
     *
     * @param string $punktRosy
     * @return PrzygotowanieDoAplikacji
     */
    public function setPunktRosy($punktRosy)
    {
        $this->punktRosy = $punktRosy;

        return $this;
    }

    /**
     * Get punktRosy
     *
     * @return string 
     */
    public function getPunktRosy()
    {
        return $this->punktRosy;
    }

    /**
     * Add produktyUtwardzacze
     *
     * @param ProduktUtwardzacz $produktyUtwardzacze
     * @return PrzygotowanieDoAplikacji
     */
    public function addProduktyUtwardzacze(ProduktUtwardzacz $produktyUtwardzacze)
    {
        $this->produktyUtwardzacze[] = $produktyUtwardzacze;
        $produktyUtwardzacze->setProdukt($this);

        return $this;
    }

    /**
     * Remove produktyUtwardzacze
     *
     * @param ProduktUtwardzacz $produktyUtwardzacze
     */
    public function removeProduktyUtwardzacze(ProduktUtwardzacz $produktyUtwardzacze)
    {
        $this->produktyUtwardzacze->removeElement($produktyUtwardzacze);
    }

    /**
     * Get produktyUtwardzacze
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduktyUtwardzacze()
    {
        return $this->produktyUtwardzacze;
    }

    /**
     * Add produktyRozcienczalniki
     *
     * @param ProduktRozcienczalnik $produktyRozcienczalniki
     * @return PrzygotowanieDoAplikacji
     */
    public function addProduktyRozcienczalniki(ProduktRozcienczalnik $produktyRozcienczalniki)
    {
        $this->produktyRozcienczalniki[] = $produktyRozcienczalniki;
        $produktyRozcienczalniki->setPrzygotowanie($this);

        return $this;
    }

    /**
     * Add addProduktyRozcienczalnikus
     *
     * @param ProduktRozcienczalnik $produktyRozcienczalniki
     * @return PrzygotowanieDoAplikacji
     */
    public function addProduktyRozcienczalnikus(ProduktRozcienczalnik $produktyRozcienczalniki)
    {
        $this->produktyRozcienczalniki[] = $produktyRozcienczalniki;
        $produktyRozcienczalniki->setPrzygotowanie($this);

        return $this;
    }

    /**
     * Remove produktyRozcienczalniki
     *
     * @param ProduktRozcienczalnik $produktyRozcienczalniki
     */
    public function removeProduktyRozcienczalniki(ProduktRozcienczalnik $produktyRozcienczalniki)
    {
        $this->produktyRozcienczalniki->removeElement($produktyRozcienczalniki);
    }

    /**
     * Remove removeProduktyRozcienczalnikus
     *
     * @param ProduktRozcienczalnik $produktyRozcienczalniki
     */
    public function removeProduktyRozcienczalnikus(ProduktRozcienczalnik $produktyRozcienczalniki)
    {
        $this->produktyRozcienczalniki->removeElement($produktyRozcienczalniki);
    }

    /**
     * Get produktyRozcienczalniki
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProduktyRozcienczalniki()
    {
        return $this->produktyRozcienczalniki;
    }

    /**
     * @Assert\Callback
     */
    public function isLepkoscStomerValidate(ExecutionContextInterface $context)
    {
        if($this->lepkoscStomerMIN > $this->lepkoscStomerMAX)
        {
            $context->addViolationAt(
                'lepkoscStomerMIN',
                'Lepkość minimalna nie może być większa od maksymalnej!',
                array(),
                null
            );

            $context->addViolationAt(
                'lepkoscStomerMAX',
                'Lepkość maksymalna nie może być mniejsza od minimalnej!',
                array(),
                null
            );
        }
    }

    /**
     * @Assert\Callback
     */
    public function isLepkoscFordValidate(ExecutionContextInterface $context)
    {
        if($this->lepkoscFordMIN > $this->lepkoscFordMAX)
        {
            $context->addViolationAt(
                'lepkoscFordMIN',
                'Lepkość minimalna nie może być większa od maksymalnej!',
                array(),
                null
            );

            $context->addViolationAt(
                'lepkoscFordMAX',
                'Lepkość maksymalna nie może być mniejsza od minimalnej!',
                array(),
                null
            );
        }
    }

    /**
     * @return string
     */
    public function getUwagi()
    {
        return $this->uwagi;
    }

    /**
     * @param string $uwagi
     */
    public function setUwagi($uwagi)
    {
        $this->uwagi = $uwagi;
    }
}
