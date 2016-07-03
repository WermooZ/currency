<?php

namespace OAuthBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Request\ParamFetcherInterface;

class RestController extends Controller
{

    public function getArticlesAction(ParamFetcherInterface $paramFetcher)
    {
//        $page = $paramFetcher->get('page');
//        $articles = array('bim', 'bam', 'bingo');
//
//        $data = new HelloResponse($articles, $page);
//        $view = new View($data);
//        $view->setTemplate('LiipHelloBundle:Rest:getArticles.html.twig');
//
//        return $this->get('fos_rest.view_handler')->handle($view);

        $data = array("hello" => "world");
        $view = new View($data);
        $view->setTemplate('OAuthBundle:Rest:rest.html.twig');
        return $this->get('fos_rest.view_handler')->handle($view);
    }
}

