<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Form\Type\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 * @package AppBundle\Controller
 */
class UserController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function registerAction()
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        return $this->render('@App/User/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
