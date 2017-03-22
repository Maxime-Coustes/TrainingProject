<?php

namespace CoreBundle\Entity;

/**
 * TypeArticle
 */
class TypeArticle
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $kindof;

    /**
     * @var string
     */
    private $articles;


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
     * Set kindof
     *
     * @param string $kindof
     *
     * @return TypeArticle
     */
    public function setKindof($kindof)
    {
        $this->kindof = $kindof;

        return $this;
    }

    /**
     * Get kindof
     *
     * @return string
     */
    public function getKindof()
    {
        return $this->kindof;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add article
     *
     * @param \CoreBundle\Entity\Articles $article
     *
     * @return TypeArticle
     */
    public function addArticle(\CoreBundle\Entity\Articles $article)
    {
        $this->articles[] = $article;

        return $this;
    }

    /**
     * Remove article
     *
     * @param \CoreBundle\Entity\Articles $article
     */
    public function removeArticle(\CoreBundle\Entity\Articles $article)
    {
        $this->articles->removeElement($article);
    }

    /**
     * Get articles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArticles()
    {
        return $this->articles;
    }
}
