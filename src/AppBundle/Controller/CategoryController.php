<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DefaultController
 * @package AppBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('AppBundle:Category')->find($id);

        $videos = $this->getDoctrine()->getRepository('AppBundle:Video')->findBy(['category' => $category]);

        return $this->render('@App/Category/read.html.twig', [
            'category' => $category,
            'videos' => $videos,
        ]);
    }
}
