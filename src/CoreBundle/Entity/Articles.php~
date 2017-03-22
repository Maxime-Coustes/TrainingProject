<?php

namespace CoreBundle\Entity;

/**
 * Articles
 */
class Articles
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $date;

    /**
     * @var string
     */
    private $images;

    /**
     * @var string
     */
    private $typeArticle;

    /**
     * @var string
     */
    private $users;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Articles
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set date
     *
     * @param string $date
     *
     * @return Articles
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }
    /**
     * @var string
     */
    private $contenu;


    /**
     * Set contenu
     *
     * @param string $contenu
     *
     * @return Articles
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;

        return $this;
    }

    /**
     * Get contenu
     *
     * @return string
     */
    public function getContenu()
    {
        return $this->contenu;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->typeArticle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set images
     *
     * @param \CoreBundle\Entity\Images $images
     *
     * @return Articles
     */
    public function setImages(\CoreBundle\Entity\Images $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \CoreBundle\Entity\Images
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set users
     *
     * @param \CoreBundle\Entity\Users $users
     *
     * @return Articles
     */
    public function setUsers(\CoreBundle\Entity\Users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \CoreBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add typeArticle
     *
     * @param \CoreBundle\Entity\typeArticle $typeArticle
     *
     * @return Articles
     */
    public function addTypeArticle(\CoreBundle\Entity\typeArticle $typeArticle)
    {
        $this->typeArticle[] = $typeArticle;

        return $this;
    }

    /**
     * Remove typeArticle
     *
     * @param \CoreBundle\Entity\typeArticle $typeArticle
     */
    public function removeTypeArticle(\CoreBundle\Entity\typeArticle $typeArticle)
    {
        $this->typeArticle->removeElement($typeArticle);
    }

    /**
     * Get typeArticle
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTypeArticle()
    {
        return $this->typeArticle;
    }
}
