<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadUserData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadUserData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface|null $container
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $user_01 = new User();
        $user_01
            ->setUsername('fanel.dev@gmail.com')
            ->setSalt(base_convert(sha1(uniqid(mt_rand(), true)), 16, 36))
            ->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->container->get('app.security.encoder.password')->encodePassword('admin', $user_01->getSalt()))
        ;
        $manager->persist($user_01);

        $manager->flush();
    }
}
