<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $videos = $this->getDoctrine()->getRepository('AppBundle:Video')->getActive();

        return $this->render('@App/Default/index.html.twig', [
            'videos' => $videos,
        ]);
    }
}
