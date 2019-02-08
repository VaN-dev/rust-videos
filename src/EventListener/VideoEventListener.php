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
        $pattern = '/https:\/\/www.youtube.com\/watch\?v=(?P<identifier>[\w-]+)/i';
        if (preg_match($pattern, $event->getVideo()->getUrl(), $matches)) {
//            $embed = 'https://www.youtube.com/embed/' . $matches['identifier'];
//            $video->setEmbed($embed);
            $event->getVideo()->setRemoteId($matches['identifier']);
            $this->client->getVideoData($event->getVideo());
        }

        $this->uriToEmbedConverter->convert($event->getVideo());
    }
}
