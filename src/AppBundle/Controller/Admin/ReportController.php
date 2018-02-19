<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Report;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class ReportController extends Controller
{
    /**
     * @Route("/admin/report", name="admin.report")
     */
    public function indexAction()
    {
        $pendingReports = $this->getDoctrine()->getRepository('AppBundle:Report')->getPendingReports();
        $confirmedReports = $this->getDoctrine()->getRepository('AppBundle:Report')->getConfirmedReports();
        $dismissedReports = $this->getDoctrine()->getRepository('AppBundle:Report')->getDismissedReports();

        return $this->render('@App/Admin/Report/index.html.twig', [
            'pendingReports' => $pendingReports,
            'confirmedReports' => $confirmedReports,
            'dismissedReports' => $dismissedReports,
        ]);
    }

    /**
     * @Route("/admin/report/{report}", name="admin.report.read")
     */
    public function readAction(Report $report)
    {
        return $this->render('@App/Admin/Report/read.html.twig', [
            'report' => $report,
        ]);
    }

    /**
     * @Route("/admin/report/{report}/confirm", name="admin.report.confirm")
     */
    public function confirmReport(Report $report)
    {
        $report
            ->setStatus(Report::STATUS_CONFIRMED)
            ->getVideo()
                ->setStatus(false)
        ;

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Report successfully confirmed.');

        return new RedirectResponse($this->generateUrl('admin.report'));
    }

    /**
     * @Route("/admin/report/{report}/dismiss", name="admin.report.dismiss")
     */
    public function dismissReport(Report $report)
    {
        $report
            ->setStatus(Report::STATUS_DISMISSED)
            ->getVideo()
                ->setStatus(true)
        ;

        $this->getDoctrine()->getManager()->flush();

        $this->addFlash('success', 'Report successfully dismissed.');

        return new RedirectResponse($this->generateUrl('admin.report'));
    }
}
