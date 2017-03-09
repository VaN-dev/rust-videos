<?php

namespace AppBundle\EventListener;

use AppBundle\Event\VideoEvent;
use AppBundle\Service\Converter\Video\UriToEmbedConverter;

/**
 * Class VideoEventListener
 * @package AppBundle\EventListener
 */
class VideoEventListener
{
    /**
     * @var UriToEmbedConverter
     */
    private $uriToEmbedConverter;

    /**
     * VideoEventListener constructor.
     * @param UriToEmbedConverter $uriToEmbedConverter
     */
    public function __construct(UriToEmbedConverter $uriToEmbedConverter)
    {
        $this->uriToEmbedConverter = $uriToEmbedConverter;
    }

    /**
     * @param VideoEvent $event
     */
    public function preSave(VideoEvent $event)
    {
        $this->uriToEmbedConverter->convert($event->getVideo());
    }
}