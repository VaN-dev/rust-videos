<?php

namespace AppBundle\Event;

use AppBundle\Entity\Video;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class VideoEvent
 * @package AppBundle\Event
 */
class VideoEvent extends Event
{
    /**
     * @var Video
     */
    private $video;

    /**
     * VideoEvent constructor.
     * @param Video $video
     */
    public function __construct(Video $video)
    {
        $this->video = $video;
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
     * @return VideoEvent
     */
    public function setVideo($video)
    {
        $this->video = $video;
        return $this;
    }


}