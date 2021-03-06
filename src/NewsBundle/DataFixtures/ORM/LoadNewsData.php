<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use NewsBundle\Entity\News;

/**
 * Class LoadNewsData
 */
class LoadNewsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $news = new News();
        $news->setAuthor($this->getReference('user'));
        $news->setTitle('title');
        $news->setContent('bla bla bla..');

        $manager->persist($news);
        $manager->flush();

        $this->addReference('news', $news);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 30;
    }
}