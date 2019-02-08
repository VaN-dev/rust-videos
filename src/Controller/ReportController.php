<?php

namespace App\Controller;

use App\AppEvents;
use App\Entity\Report;
use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class VideoController
 * @package App\Controller
 */
class ReportController extends AbstractController
{
    /**
     * @param Request $request
     * @return RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function create(Request $request, Video $video)
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
