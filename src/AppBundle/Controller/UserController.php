<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\ProfileType;
use AppBundle\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Profiler\Profile;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                // Password encoding
                $passwordEncoding = $this->get('app.security.encoder.password');
                $user->setPassword($passwordEncoding->encodePassword($user->getPassword(), $user->getSalt()));

                $em = $this->getDoctrine()->getManager();
                $em->persist($user);
                $em->flush();

                $request->getSession()->getFlashBag()->add('success', '<strong>Well done!</strong> You successfully registered.');

                return $this->redirect($this->generateUrl('app'));
            }
        }

        return $this->render('@App/User/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function profileAction(Request $request)
    {
        $form = $this->createForm(ProfileType::class, $this->getUser(), [
            'method' => Request::METHOD_PATCH,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $data = $form->getData();

                if (null !== $data->getPassword()) {
                    die('updating pass');
                    // Password encoding
                    $passwordEncoding = $this->get('app.security.encoder.password');
                    $this->getUser()->setPassword($passwordEncoding->encodePassword($this->getUser()->getPassword(), $this->getUser()->getSalt()));
                }

                $this->getDoctrine()->getManager()->flush();

                $request->getSession()->getFlashBag()->add('success', '<strong>Well done!</strong> Profile successfully updated.');

                return $this->redirect($this->generateUrl('app.user.profile'));
            }
        }

        return $this->render('@App/User/profile.html.twig', [
            'form' => $form->createView(),
        ]);

        return $this->render('@App/User/profile.html.twig');
    }


    public function bookmarksAction()
    {
        $bookmarks = $this->getDoctrine()->getRepository('AppBundle:Bookmark')->findBy(['user' => $this->getUser()]);

        return $this->render('@App/User/bookmarks.html.twig', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
