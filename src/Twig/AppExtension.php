<?php

namespace App\Twig;

use App\Entity\Bookmark;
use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $tokenStorage;
    private $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
    }

    public function getFunctions() {
        return [
             new TwigFunction('is_bookmarked', [$this, 'isBookmarked'])
        ];
    }

    public function getFilters()
    {
        return [
            new TwigFilter('truncate', [$this, 'truncate']),
        ];
    }

    public function isBookmarked(Video $video)
    {
        $bookmark = $this->em->getRepository(Bookmark::class)->findOneBy(['user' => $this->tokenStorage->getToken()->getUser(), 'video' => $video]);

        return (bool) $bookmark;
    }

    public function truncate($value, $length = 30, $preserve = false, $separator = '...')
    {
        if (mb_strlen($value) > $length) {
            if ($preserve) {
                // If breakpoint is on the last word, return the value without separator.
                if (false === ($breakpoint = mb_strpos($value, ' ', $length))) {
                    return $value;
                }
                $length = $breakpoint;
            }
            return rtrim(mb_substr($value, 0, $length)).$separator;
        }
        return $value;
    }
}
