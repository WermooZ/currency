<?php

namespace NewsBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Request\ParamFetcher;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use NewsBundle\Services\NewsService;

class RestController extends FosRestController
{
    /**
     * @QueryParam(name="author", requirements="\d+", allowBlank=true, nullable=true, description="news author filter")
     * @QueryParam(name="status", requirements="\d+", allowBlank=true, nullable=true, description="news status filter")
     */
    public function getNewsAction(ParamFetcher $paramFetcher)
    {
        $newsService = $this->get('news.news_service');
        $news = $newsService->getNewsIdsByFilters([
            NewsService::AUTHOR_FILTER => $paramFetcher->get('author'),
            NewsService::STATUS_FILTER => $paramFetcher->get('status'),
        ]);

        $data = [
            'Found news ids:' => implode(', ', $news)
        ];

        $view = $this->view($data, Response::HTTP_FOUND );
        return $this->handleView($view);
    }

    /**
     * @RequestParam(name="title", description="news title")
     * @RequestParam(name="content", description="news content")
     */
    public function putNewsAction(ParamFetcher $paramFetcher)
    {
        $currentUser = $this->getUser();
        $title = $paramFetcher->get('title');
        $content = $paramFetcher->get('content');

        $newsService = $this->get('news.news_service');

        $news = $newsService->create($currentUser, $title, $content);

        $em = $this->getDoctrine()->getManager();
        $em->persist($news);
        $em->flush();

        $data = [
            'message' => 'News with id: '.$news->getId(). ' has been created.',
        ];

        $view = $this->view($data, Response::HTTP_CREATED );

        return $this->handleView($view);
    }

    /**
     * @RequestParam(name="title", nullable=true, description="news title")
     * @RequestParam(name="content", nullable=true, description="news content")
     * @RequestParam(name="status", nullable=true, description="news status")
     */
    public function postNewsAction($newsId, ParamFetcher $paramFetcher)
    {

        $news = $this->get('news.news_repository')->fetchOneByIdAndUser(
            $newsId, $this->getUser()
        );

        if ($news === null) {
            $view = $this->view(['Not Found'], Response::HTTP_NOT_FOUND);
        } else {
            $newsService = $this->get('news.news_service');

            $newsService->update(
                $news,
                $paramFetcher->get('title'),
                $paramFetcher->get('content'),
                $paramFetcher->get('status')
            );

            $em = $this->getDoctrine()->getManager();
            $em->flush();

            $view = $this->view(
                ['News with id: '.$newsId.' has been updated'],
                Response::HTTP_OK
            );

        }

        return $this->handleView($view);
    }

    /**
     * @param integer $newsId
     *
     * @return Response
     */
    public function deleteNewsAction($newsId)
    {
        $news = $this->get('news.news_repository')->fetchOneByIdAndUser(
            $newsId, $this->getUser()
        );

        if ($news === null) {
            $view = $this->view(['Not Found'], Response::HTTP_NOT_FOUND);
        } else {
            $view = $this->view(
                ['News with id: '.$newsId.' has been deleted'],
                Response::HTTP_OK
            );

            $em = $this->getDoctrine()->getManager();

            $em->remove($news);
            $em->flush();
        }

        return $this->handleView($view);
    }
}
