<?php

namespace App\Controller;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class DefaultController
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        $videos = $this->getDoctrine()->getRepository(Video::class)->getActive();

        return $this->render('default/index.html.twig', [
            'videos' => $videos,
        ]);
    }
}
