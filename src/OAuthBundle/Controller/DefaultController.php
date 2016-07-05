<?php

namespace OAuthBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function addClientAction()
    {
        $clientManager = $this->get('fos_oauth_server.client_manager.default');

        $client = $clientManager->createClient();

        $client->setRedirectUris(array('127.0.0.1'));
        $client->setAllowedGrantTypes(array('token', 'authorization_code', 'password', 'client_credentials'));
        $clientManager->updateClient($client);

        $output = sprintf("Added client with id: %s secret: %s",$client->getPublicId(),$client->getSecret());

        return new Response($output);

//        return $this->redirect($this->generateUrl('fos_oauth_server_authorize', array(
//            'client_id'     => $client->getPublicId(),
//            'redirect_uri'  => 'http://www.example.com',
//            'response_type' => 'code'
//        )));
    }
}
