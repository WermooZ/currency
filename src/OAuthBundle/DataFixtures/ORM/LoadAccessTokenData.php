<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OAuthBundle\Entity\AccessToken;

class LoadAccessTokenData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $token = new AccessToken();
        $token->setClient($this->getReference('client'));
        $token->setUser($this->getReference('user'));
        $token->setToken('YWI5ODE2M2JiNjVhMGY5YWJjNzE2ODhhMTY4Y2Y4MTAzYTUwYWU3MGM4NTk2ZWY1ODE0Yzc3NDJlNzY0MzNjZA');
        $token->setExpiresAt(1499260129);
        $token->setScope('user');

        $manager->persist($token);
        $manager->flush();

        $this->addReference('token', $token);
    }

    public function getOrder()
    {
        return 30;
    }
}