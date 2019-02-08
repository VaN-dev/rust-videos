<?php

namespace App\Controller;

use App\AppEvents;
use App\Entity\Video;
use App\Event\VideoEvent;
use App\Form\Type\VideoType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VideoController
 * @package App\Controller
 */
class VideoController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $videos = $this->getDoctrine()->getRepository(Video::class)->findAll();

        return $this->render('video/index.html.twig', [
            'videos' => $videos,
        ]);
    }

    /**
     * @param Request $request
     * @param EventDispatcherInterface $eventDispatcher
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, EventDispatcherInterface $eventDispatcher)
    {
        $em = $this->getDoctrine()->getManager();

        $video = new Video();

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $video->setAddedBy($this->getUser());
        }

        $form = $this->createForm(VideoType::class, $video);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($video);

            /**
             * pre save event
             */
            $eventDispatcher->dispatch(AppEvents::VIDEO_PRE_SAVE, new VideoEvent($video));

            $em->flush();

            return new RedirectResponse($this->generateUrl('app.video'));
        }

        return $this->render('video/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Video $video
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function read(Video $video)
    {
        return $this->render('video/read.html.twig', [
            'video' => $video,
        ]);
    }
}
