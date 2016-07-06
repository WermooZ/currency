<?php

namespace UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OAuthBundle\Entity\Client;

/**
 * Class LoadClientData
 */
class LoadClientData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $client = new Client();
        $client->setRandomId('a3lr7mjzi60wwg4s008s0w8c0kkgog800o0g44c08g88c8wgs');
        $client->setRedirectUris(['127.0.0.1']);
        $client->setSecret('5fueks2vf30g0w8c4w0wsks8sgsw4044gso8c0wogwkoocgosc');
        $client->setAllowedGrantTypes(['token', 'authorization_code', 'password', 'client_credentials']);

        $manager->persist($client);
        $manager->flush();

        $this->addReference('client', $client);
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return 20;
    }
}