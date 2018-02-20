<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Category;
use AppBundle\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package AppBundle\Controller
 */
class CategoryController extends Controller
{
    /**
     * @Route("/admin/category", name="admin.category")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository('AppBundle:Category')->findAll();

        return $this->render('AppBundle:Admin/Category:index.html.twig', [
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/admin/category/create", name="admin.category.create")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->persist($category);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Category successfully created.');

                return $this->redirect($this->generateUrl('admin.category'));
            }
        }

        return $this->render('AppBundle:Admin/Category:create.html.twig', [
            'form' => $form->createView(),
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

    /**
     * @Route("/admin/category/{category}/update", name="admin.category.update")
     */
    public function updateAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', 'Category successfully updated.');

                return $this->redirect($this->generateUrl('admin.category'));
            }
        }

        return $this->render('AppBundle:Admin/Category:update.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/category/{category}/delete", name="admin.category.delete")
     */
    public function deleteAction(Request $request, Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($category);
        $em->flush();

        $request->getSession()->getFlashBag()->add('success', 'Category successfully deleted.');

        return $this->redirect($this->generateUrl('admin.category'));
    }
}
