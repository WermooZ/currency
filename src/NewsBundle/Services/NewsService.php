<?php

namespace NewsBundle\Services;

use UserBundle\Entity\User;
use NewsBundle\Entity\News;
use NewsBundle\Repository\NewsRepository;

/**
 * Class NewsService
 */
class NewsService
{
    const AUTHOR_FILTER = 'author';
    const STATUS_FILTER = 'status';

    /**
     * @var NewsRepository
     */
    private $newsRepository;

    /**
     * @param NewsRepository $newsRepository
     */
    public function __construct(NewsRepository $newsRepository)
    {
        $this->newsRepository = $newsRepository;
    }

    /**
     * @param News $news
     * @param User $user
     *
     * @return bool
     */
    public function isAuthor(News $news, User $user)
    {
        return $news->getAuthor() === $user;
    }

    /**
     * @param User   $author
     * @param string $title
     * @param string $content
     * 
     * @return News
     */
    public function create(User $author, $title, $content='')
    {
        $news = new News();
        $news->setAuthor($author);
        $news->setTitle($title);
        $news->setContent($content);
        
        return $news;
    }

    /**
     * @param News        $news
     * @param string|null $title
     * @param string|null $content
     * @param string|null $status
     *
     * @return News
     */
    public function update(News $news, $title, $content, $status)
    {
        if ($title !== null) {
            $news->setTitle($title);
        }
        if ($content !== null) {
            $news->setContent($content);
        }
        if ($status !== null) {
            $news->setStatus($status);
        }

        return $news;
    }

    /**
     * @param array $filters
     *
     * @return array
     */
    public function getNewsIdsByFilters(array $filters)
    {
        $newsIds = $this->newsRepository->fetchIdsByFilters($filters);

        $result = [];
        foreach ($newsIds as $row) {
            $result[] = $row['id'];
        }

        return $result;
    }
}