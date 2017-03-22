<?php

namespace CoreBundle\Entity;

/**
 * Images
 */
class Images
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $chemin;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $articleAffilie;




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
     * Set chemin
     *
     * @param string $chemin
     *
     * @return Images
     */
    public function setChemin($chemin)
    {
        $this->chemin = $chemin;

        return $this;
    }

    /**
     * Get chemin
     *
     * @return string
     */
    public function getChemin()
    {
        return $this->chemin;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Images
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
     * Constructor
     */
    public function __construct()
    {
        $this->articleAffilie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add articleAffilie
     *
     * @param \CoreBundle\Entity\Articles $articleAffilie
     *
     * @return Images
     */
    public function addArticleAffilie(\CoreBundle\Entity\Articles $articleAffilie)
    {
        $this->articleAffilie[] = $articleAffilie;

        return $this;
    }

    /**
     * Remove articleAffilie
     *
     * @param \CoreBundle\Entity\Articles $articleAffilie
     */
    public function removeArticleAffilie(\CoreBundle\Entity\Articles $articleAffilie)
    {
        $this->articleAffilie->removeElement($articleAffilie);
    }

    /**
     * Get articleAffilie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticleAffilie()
    {
        return $this->articleAffilie;
    }
}
