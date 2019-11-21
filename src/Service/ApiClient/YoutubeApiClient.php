<?php

namespace App\Service\ApiClient;

use App\Entity\Video;
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

        return [
            'title' => $data->items[0]->snippet->title,
            'channelTitle' => $data->items[0]->snippet->channelTitle,
            'thumbnail' => $data->items[0]->snippet->thumbnails->default->url,
        ];
    }
}
