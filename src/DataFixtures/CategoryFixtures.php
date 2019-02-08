<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
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
