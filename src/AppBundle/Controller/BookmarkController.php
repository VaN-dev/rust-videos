<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bookmark;
use AppBundle\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BookmarkController
 * @package AppBundle\Controller
 */
class BookmarkController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, Video $video)
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

    public function deleteAction(Request $request, Video $video)
    {
        $em = $this->getDoctrine()->getManager();

        $bookmark = $em->getRepository('AppBundle:Bookmark')->findOneBy(['user' => $this->getUser(), 'video' => $video]);

        if (null !== $bookmark) {
            $em->remove($bookmark);
            $em->flush();

            $this->addFlash('success', 'Bookmark successsfully deleted.');
        }

        return new RedirectResponse($request->headers->get('referer'));
    }
}
