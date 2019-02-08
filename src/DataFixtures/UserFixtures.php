<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user_01 = new User();
        $user_01
            ->setEmail('fanel.dev@gmail.com')
            ->setRoles(["ROLE_ADMIN"])
        ;
        $user_01->setPassword($this->passwordEncoder->encodePassword($user_01, 'admin'));
        $manager->persist($user_01);

        $manager->flush();
    }
}
