<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadScopeData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadCategoryData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $category_01 = new Category();
        $category_01
            ->setName('Base designs')
        ;
        $manager->persist($category_01);

        $manager->flush();
    }
}