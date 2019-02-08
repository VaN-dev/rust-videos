<?php

namespace App\Service\Converter\Video;
use App\Entity\Video;

/**
 * Class UriToEmbedConverter
 * @package App\Service\Converter\Video
 */
class UriToEmbedConverter
{
    /**
     * @param Video $video
     */
    public function convert(Video $video)
    {
        $pattern = '/https:\/\/www.youtube.com\/watch\?v=(?P<identifier>[\w-]+)/i';
        if (preg_match($pattern, $video->getUrl(), $matches)) {
            $embed = 'https://www.youtube.com/embed/' . $matches['identifier'];
            $video->setEmbed($embed);
        }
    }
}