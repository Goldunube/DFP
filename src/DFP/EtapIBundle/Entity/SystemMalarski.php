<?php

namespace DFP\EtapIBundle\Entity;

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
     *
     */
    private $komentarz;

    private $popularnosc;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}
