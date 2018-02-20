<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 */
class CategoryController extends Controller
{
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();

        return $this->render('@App/Category/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function readAction(Category $category)
    {
        return $this->render('@App/Category/read.html.twig', [
            'category' => $category,
        ]);
    }
}
