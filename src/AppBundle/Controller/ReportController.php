<?php

namespace AppBundle\Controller;

use AppBundle\AppEvents;
use AppBundle\Entity\Report;
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
class ReportController extends Controller
{
    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function createAction(Request $request, Video $video)
    {
        $em = $this->getDoctrine()->getManager();

        $report = (new Report())
            ->setVideo($video)
        ;

        if ($this->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $report->setCreatedBy($this->getUser());
        }

        $em->persist($report);
        $em->flush();

        $this->addFlash('success', 'You successfully reported this video.');

        return new RedirectResponse($request->headers->get('referer'));
    }
}
