<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProfilSystem
 *
 * @ORM\Table(name="profiledzialalnosci_systemymalarskie")
 * @ORM\Entity
 */
class ProfilSystem
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
     * @ORM\Column(name="komentarz", type="string", length=255)
     */
    private $komentarz;

    /**
     * @ORM\ManyToOne(targetEntity="ProfilDzialalnosci", inversedBy="profileSystemy")
     * @ORM\JoinColumn(name="profil_id", referencedColumnName="id", nullable=false)
     */
    private $profilDzialalnosci;

    /**
     * @ORM\ManyToOne(targetEntity="SystemMalarski", inversedBy="profileSystemy")
     * @ORM\JoinColumn(name="system_id", referencedColumnName="id", nullable=false)
     */
    private $systemMalarski;

    /**
     * @ORM\OneToMany(targetEntity="OfertaHandlowaProfilSystem", mappedBy="profilSystem", cascade={"persist"}, orphanRemoval=true)
     */
    protected $ofertyProfileSystemy;


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
     * @return ProfilSystem
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
     * Set profilDzialalnosci
     *
     * @param ProfilDzialalnosci $profilDzialalnosci
     * @return ProfilSystem
     */
    public function setProfilDzialalnosci(ProfilDzialalnosci $profilDzialalnosci)
    {
        $this->profilDzialalnosci = $profilDzialalnosci;
    
        return $this;
    }

    /**
     * Get profilDzialalnosci
     *
     * @return ProfilDzialalnosci
     */
    public function getProfilDzialalnosci()
    {
        return $this->profilDzialalnosci;
    }

    /**
     * Set systemMalarski
     *
     * @param SystemMalarski $systemMalarski
     * @return ProfilSystem
     */
    public function setSystemMalarski(SystemMalarski $systemMalarski)
    {
        $this->systemMalarski = $systemMalarski;
    
        return $this;
    }

    /**
     * Get systemMalarski
     *
     * @return SystemMalarski
     */
    public function getSystemMalarski()
    {
        return $this->systemMalarski;
    }
}