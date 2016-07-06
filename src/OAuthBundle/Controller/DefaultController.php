<?php

namespace OAuthBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DefaultController
 */
class DefaultController extends Controller
{
    /**
     * @return mixed
     */
    public function addClientAction()
    {
        $clientManager = $this->get('fos_oauth_server.client_manager.default');

        $client = $clientManager->createClient();
        $client->setRedirectUris(array('127.0.0.1'));
        $client->setAllowedGrantTypes(array('token', 'authorization_code', 'password', 'client_credentials'));
        $clientManager->updateClient($client);

        $this->addFlash(
            'notice',
            'Added client with ID: '.$client->getPublicId(). ' SECRET: '.$client->getSecret()
        );

        return $this->redirectToRoute('homepage');
    }
}
