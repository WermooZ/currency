<?php

namespace RestBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class DefaultController extends FosRestController
{
    public function getTestAction()
    {
        $data = [
            'type' => 'Spicy',
            'quantity' => '30ml',
        ];
        $view = $this->view($data,200);
        return $this->handleView($view);
    }
}
