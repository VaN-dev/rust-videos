<?php

namespace AppBundle\Controller;

use AppBundle\AppEvents;
use AppBundle\Entity\Video;
use AppBundle\Event\VideoEvent;
use AppBundle\Form\Type\VideoType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VideoController
 * @package AppBundle\Controller
 */
class VideoController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $videos = $this->getDoctrine()->getRepository('AppBundle:Video')->findAll();

        return $this->render('@App/Video/index.html.twig', [
            'videos' => $videos,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dispatcher = $this->get('event_dispatcher');

        $video = new Video();

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $video->setAddedBy($this->getUser());
        }

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($video);

                /**
                 * pre save event
                 */
                $dispatcher->dispatch(AppEvents::VIDEO_PRE_SAVE, new VideoEvent($video));

                $em->flush();

                return new RedirectResponse($this->generateUrl('app.video'));
            }
        }

        return $this->render('@App/Video/insert.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Video $video
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction(Video $video)
    {
        return $this->render('@App/Video/read.html.twig', [
            'video' => $video,
        ]);
    }
}
