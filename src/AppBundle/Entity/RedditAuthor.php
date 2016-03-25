<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="reddit_author", indexes={
 *   @ORM\Index(name="index_author_name", columns={"name"})
 * })
 */
class RedditAuthor
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RedditPost", mappedBy="author")
     */
    protected $posts;


    /**
     * RedditAuthor constructor.
     */
    public function __construct()
    {
        $this->posts = new ArrayCollection();
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return RedditAuthor
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


}