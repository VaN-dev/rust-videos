<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadCategoryData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadCategoryData extends AbstractFixture
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

        $this->setReference('category-basedesigns', $category_01);
    }
}
