<?php

namespace AppBundle\Service\ApiClient;

use AppBundle\Entity\Video;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

class YoutubeApiClient
{
    private $key;
    private $client;

    public function __construct($key)
    {
        $this->key = $key;
        $this->client = new Client();
    }

    public function getVideoData(Video $video)
    {
        $res = $this->client->request('GET', 'https://www.googleapis.com/youtube/v3/videos?part=id,+snippet&id='.$video->getRemoteId().'&key='.$this->key);
        $data = \GuzzleHttp\json_decode($res->getBody()->getContents());
//        dump($data);
//        dump($data->items[0]->snippet->description);
//        die();


        $video
            ->setTitle($data->items[0]->snippet->title)
            ->setAuthor($data->items[0]->snippet->channelTitle)
            ->setThumbnail($data->items[0]->snippet->thumbnails->default->url)
        ;
    }
}
