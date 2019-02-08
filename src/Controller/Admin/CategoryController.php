<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\Type\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CategoryController
 * @package App\Controller
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="admin.category")
     */
    public function indexAction()
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();

        return $this->render('admin/category/index.html.twig', [
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

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Category successfully created.');

            return $this->redirect($this->generateUrl('admin.category'));
        }

        return $this->render('admin/category/create.html.twig', [
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

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            $request->getSession()->getFlashBag()->add('success', 'Category successfully updated.');

            return $this->redirect($this->generateUrl('admin.category'));
        }

        return $this->render('admin/category/update.html.twig', [
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
