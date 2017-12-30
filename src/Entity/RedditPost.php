<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RedditPost
 * @package App\Entity
 *
 * @ORM\Entity(repositoryClass="App\Entity\Repository\RedditPostRepository")
 * @ORM\Table(name="reddit_posts")
 */
class RedditPost
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RedditAuthor", inversedBy="posts")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    protected $author;


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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return RedditPost
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return RedditAuthor
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return RedditPost
     */
    public function setAuthor(RedditAuthor $author)
    {
        $this->author = $author;

        return $this;
    }


}