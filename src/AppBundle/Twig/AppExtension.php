<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class AppExtension extends \Twig_Extension
{
    private $tokenStorage;
    private $em;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $em)
    {
        $this->tokenStorage = $tokenStorage;
        $this->em = $em;
    }

    public function getFunctions() {
        return array(
            'is_bookmarked' => new \Twig_Function_Method($this, 'isBookmarked')
        );
    }

    public function isBookmarked(Video $video)
    {
        $bookmark = $this->em->getRepository('AppBundle:Bookmark')->findOneBy(['user' => $this->tokenStorage->getToken()->getUser(), 'video' => $video]);

        return (bool) $bookmark;
    }
}
