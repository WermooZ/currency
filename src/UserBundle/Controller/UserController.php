<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class UserController
 */
class UserController extends Controller
{
    /**
     * @return mixed
     */
    public function indexAction()
    {
        return $this->render('UserBundle:User:index.html.twig');
    }
}
