<?php

namespace CoreBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
/**
 * Users
 */
class Users implements UserInterface, \Serializable
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $mail;

    /**
     * @var string
     */
    private $articles;

    /**
     * @var string
     */
    private $categories;

    /**
     * @var string
     */
    private $password;   /* notre password*/

    /**
     * @var boolean
     */
    private $isActive;

    /**
     * Constructor
     */
    public function __construct()         /* quand on fait un new user(nouvelle instance de classe), on passe dans le construct qui passe la propriété isActive = true*/

    {
        $this->articles = new \Doctrine\Common\Collections\ArrayCollection();

        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }

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
     * Set username
     *
     * @param string $username
     *
     * @return Users
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set mail
     *
     * @param string $mail
     *
     * @return Users
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail
     *
     * @return string
     */
    public function getMail()
    {
        return $this->mail;
    }



    /**
     * Add article
     *
     * @param \CoreBundle\Entity\Articles $article
     *
     * @return Users
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

    /**
     * Set categories
     *
     * @param \CoreBundle\Entity\Categories $categories
     *
     * @return Users
     */
    public function setCategories(\CoreBundle\Entity\Categories $categories = null)
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * Get categories
     *
     * @return \CoreBundle\Entity\Categories
     */
    public function getCategories()
    {
        return $this->categories;
    }



    public function getRoles()
    {
        return array('ROLE_USER');
    }


    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Users
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
}
