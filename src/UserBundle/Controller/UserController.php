<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use UserBundle\Entity\User;

class UserController extends Controller
{
    public function indexAction()
    {
     
        
        return $this->render('UserBundle:User:index.html.twig');
    }
}
