<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RedditAuthor
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
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