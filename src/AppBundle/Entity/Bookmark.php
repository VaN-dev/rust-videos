<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;

/**
 * Bookmark
 *
 * @ORM\Table(name="bookmarks",
 *      uniqueConstraints={
 *        @UniqueConstraint(name="bookmark_unique",
 *            columns={"user_id", "video_id"})
 *    }
 * )
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BookmarkRepository")
 */
class Bookmark
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false)
     */
    private $user;

    /**
     * @var Video
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Video")
     * @ORM\JoinColumn(name="video_id", nullable=false)
     */
    private $video;


    /**
     * Favorite constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Bookmark
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Bookmark
     */
    public function setUser($user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Video
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param Video $video
     * @return Bookmark
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }
}

