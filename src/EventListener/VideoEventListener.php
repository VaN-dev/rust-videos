<?php

namespace App\EventListener;

use App\Event\VideoEvent;
use App\Service\Converter\Video\UriToEmbedConverter;
use App\Service\ApiClient\YoutubeApiClient;

/**
 * Class VideoEventListener
 * @package App\EventListener
 */
class VideoEventListener
{
    /**
     * @var UriToEmbedConverter
     */
    private $uriToEmbedConverter;

    /**
     * @var YoutubeApiClient
     */
    private $client;

    /**
     * VideoEventListener constructor.
     * @param UriToEmbedConverter $uriToEmbedConverter
     */
    public function __construct(UriToEmbedConverter $uriToEmbedConverter, YoutubeApiClient $client)
    {
        $this->uriToEmbedConverter = $uriToEmbedConverter;
        $this->client = $client;
    }

    /**
     * @param VideoEvent $event
     */
    public function preSave(VideoEvent $event)
    {
        $video = $event->getVideo();

        $pattern = '/https:\/\/www.youtube.com\/watch\?v=(?P<identifier>[\w-]+)/i';
        if (preg_match($pattern, $event->getVideo()->getUrl(), $matches)) {
            $video->setRemoteId($matches['identifier']);
            $data = $this->client->getVideoData($event->getVideo());

            $video
                ->setTitle($data['title'])
                ->setAuthor($data['channelTitle'])
                ->setThumbnail($data['thumbnail'])
            ;
        }

        $this->uriToEmbedConverter->convert($video);
    }
}
