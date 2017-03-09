<?php

namespace AppBundle\Service\Converter\Video;
use AppBundle\Entity\Video;

/**
 * Class UriToEmbedConverter
 * @package AppBundle\Service\Converter\Video
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