<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookmarkController
 * @package App\Controller
 */
class BookmarkController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, Video $video)
    {
        $em = $this->getDoctrine()->getManager();

        $bookmark = (new Bookmark())
            ->setUser($this->getUser())
            ->setVideo($video)
        ;

        $em->persist($bookmark);
        $em->flush();

        $this->addFlash('success', 'You successsfully bookmarked this video.');

        return new RedirectResponse($request->headers->get('referer'));
    }

    public function delete(Request $request, Video $video)
    {
        $em = $this->getDoctrine()->getManager();

        $bookmark = $em->getRepository(Bookmark::class)->findOneBy(['user' => $this->getUser(), 'video' => $video]);

        if (null !== $bookmark) {
            $em->remove($bookmark);
            $em->flush();

            $this->addFlash('success', 'Bookmark successsfully deleted.');
        }

        return new RedirectResponse($request->headers->get('referer'));
    }
}
