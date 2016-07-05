<?php

namespace NewsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use UserBundle\Entity\User;

/**
 * News
 *
 * @ORM\Table(name="news", indexes={@ORM\Index(name="status_idx", columns={"status"})})
 * @ORM\Entity(repositoryClass="NewsBundle\Repository\NewsRepository")
 */
class News
{
    const STATUSES = [
        'waiting'   => 0,
        'published' => 1,
        'expired'   => 2,
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="UserBundle\Entity\User")
     */
    protected $author;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct()
    {
        $this->status = self::STATUSES['waiting'];
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($value)
    {
        $this->title = $value;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($value)
    {
        $this->content = $value;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor(User $value)
    {
        $this->author = $value;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($value)
    {
        $this->status = $value;
    }

    


}
