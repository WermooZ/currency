<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use UserBundle\Entity\User;

/**
 * Class LoadUserData
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
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
        $user = new User();
        $user->setUsername('user');
        $user->setEmail('email@wp.pl');
        $user->setEnabled(1);

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'password');
        $user->setPassword($password);


        $manager->persist($user);
        $manager->flush();

        $this->addReference('user', $user);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 10;
    }
}