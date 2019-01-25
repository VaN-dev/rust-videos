<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Video;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class LoadVideoData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadVideoData extends AbstractFixture
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $video_01 = new Video();
        $video_01
            ->setTitle('The Practical Starter')
            ->setUrl('https://www.youtube.com/watch?v=mfZyASuMT88')
            ->setEmbed('https://www.youtube.com/embed/mfZyASuMT88')
            ->setAuthor('xRaW')
            ->setChannel('https://www.youtube.com/channel/UCxqfN_TEQf4NxQ4nW1pBIWQ')
            ->setCategory($this->getReference('category-basedesigns'))
            ->setRemoteId('mfZyASuMT88')
        ;
        $manager->persist($video_01);

        $video_02 = new Video();
        $video_02
            ->setTitle('The Mini Fort | Solo Starter Base with a Shooting Floor | Building 3.2')
            ->setUrl('https://www.youtube.com/watch?v=jyRM81d0494')
            ->setEmbed('https://www.youtube.com/embed/jyRM81d0494')
            ->setAuthor('Evil Wurst')
            ->setChannel('https://www.youtube.com/channel/UCAbl4dsDJTrvqm2N6yu1Tqw')
            ->setCategory($this->getReference('category-basedesigns'))
            ->setRemoteId('jyRM81d0494')
        ;
        $manager->persist($video_02);

        $manager->flush();
    }
}
