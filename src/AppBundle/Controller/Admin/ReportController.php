<?php

namespace AppBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends Controller
{
    /**
     * @Route("/admin/report", name="admin.report")
     */
    public function indexAction()
    {
        $reports = $this->getDoctrine()->getRepository('AppBundle:Report')->findAll();

        return $this->render('@App/Admin/Report/index.html.twig', [
            'reports' => $reports,
        ]);
    }
}
