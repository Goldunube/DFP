<?php

namespace DFP\EtapIBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * DoPobrania
 *
 * @ORM\Table(name="do_pobrania_posts")
 * @ORM\Entity
 */
class DoPobrania
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
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = "5",
     *      max = "255"
     * )
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;

    /**
     * @Gedmo\Blameable(on="create")
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Uzytkownik")
     * @ORM\JoinColumn(name="author_id")
     */
    private $author;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="create_date", type="datetime")
     */
    private $createDate;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="modification_date", type="datetime")
     */
    private $modificationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="published_date", type="datetime", nullable=true)
     */
    private $publishedDate;

    /**
     * @var string
     *
     * @Gedmo\Slug(
     *      fields={"title"}
     * )
     * @ORM\Column(name="slug", type="string", length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(name="allowed_groups",type="array",nullable=false)
     */
    private $allowedGroups = array();

    /**
     * @ORM\ManyToOne(targetEntity="DFP\EtapIBundle\Entity\Zalacznik",cascade={"all"})
     * @ORM\JoinColumn(name="zalacznik_id")
     */
    private $zalacznik;


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
     * Set title
     *
     * @param string $title
     * @return DoPobrania
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return DoPobrania
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set createDate
     *
     * @param \DateTime $createDate
     * @return DoPobrania
     */
    public function setCreateDate($createDate)
    {
        $this->createDate = $createDate;

        return $this;
    }

    /**
     * Get createDate
     *
     * @return \DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * Set modificationDate
     *
     * @param \DateTime $modificationDate
     * @return DoPobrania
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get modificationDate
     *
     * @return \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     * @return DoPobrania
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return DoPobrania
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set author
     *
     * @param Uzytkownik $author
     * @return DoPobrania
     */
    public function setAuthor(Uzytkownik $author = null)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return Uzytkownik
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set zalacznik
     *
     * @param Zalacznik $zalacznik
     * @return DoPobrania
     */
    public function setZalacznik(Zalacznik $zalacznik = null)
    {
        $this->zalacznik = $zalacznik;

        return $this;
    }

    /**
     * Get zalacznik
     *
     * @return Zalacznik
     */
    public function getZalacznik()
    {
        return $this->zalacznik;
    }

    /**
     * Set allowedGroups
     *
     * @param array $allowedGroups
     * @return DoPobrania
     */
    public function setAllowedGroups($allowedGroups)
    {
        $this->allowedGroups = $allowedGroups;

        return $this;
    }

    /**
     * Get allowedGroups
     *
     * @return array 
     */
    public function getAllowedGroups()
    {
        return $this->allowedGroups;
    }
}
