<?php

namespace App\Controller;

use App\Entity\Bookmark;
use App\Entity\User;
use App\Form\Type\ProfileType;
use App\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request)
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

    public function profile(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(ProfileType::class, $this->getUser(), [
            'method' => Request::METHOD_PATCH,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            if (null !== $data->getPassword()) {
//                    die('updating pass');
                // Password encoding
                $this->getUser()->setPassword($passwordEncoder->encodePassword($this->getUser(), $this->getUser()->getPassword()));
            }

            $this->getDoctrine()->getManager()->flush();

            $request->getSession()->getFlashBag()->add('success', '<strong>Well done!</strong> Profile successfully updated.');

            return $this->redirect($this->generateUrl('app.user.profile'));
        }

        return $this->render('user/profile.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    public function bookmarks()
    {
        $bookmarks = $this->getDoctrine()->getRepository(Bookmark::class)->findBy(['user' => $this->getUser()]);

        return $this->render('user/bookmarks.html.twig', [
            'bookmarks' => $bookmarks,
        ]);
    }
}
