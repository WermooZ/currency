<?php

namespace NewsBundle\Tests\Services;

use NewsBundle\Services\NewsService;
use NewsBundle\Entity\News;
use UserBundle\Entity\User;

/**
 * @coversDefaultClass NewsBundle\Services\NewsService
 */
class NewsServiceTest extends \PHPUnit_Framework_TestCase
{
    /** @var NewsService $sut */
    private $sut;

    /** @var PHPUnit_Framework_MockObject_MockBuilder $newsRepositoryMock */
    private $newsRepositoryMock;

    /**
     *  set up
     */
    public function setUp()
    {
        $this->newsRepositoryMock = $this->getMockBuilder('NewsBundle\Repository\NewsRepository')
            ->disableOriginalConstructor()
            ->getMock();

        $this->sut = new NewsService($this->newsRepositoryMock);
    }

    /**
     * @covers ::isAuthor
     */
    public function testIsAuthor_AuthorIsSet_ReturnsTrue()
    {
        $author = new User();
        $news = new News();

        $news->setAuthor($author);

        $this->assertTrue($this->sut->isAuthor($news, $author));
    }

    /**
     * @covers ::isAuthor
     */
    public function testIsAuthor_AuthorIsNotSet_ReturnsFalse()
    {
        $user = new User();
        $author = new User();
        $news = new News();

        $news->setAuthor($author);

        $this->assertFalse($this->sut->isAuthor($news, $user));
    }

    /**
     * @covers ::isAuthor
     */
    public function testIsAuthor_DifferenAuthorIsSet_ReturnsFalse()
    {
        $user = new User();
        $news = new News();

        $this->assertFalse($this->sut->isAuthor($news, $user));
    }

    /**
     * @covers ::getNewsIdsByFilters
     */
    public function testGetNewsIdsByFilters_EmptyFiltersGiven_ReturnsResult()
    {
        $filters = [];
        $values = [['id' => 1]];
        $expectedResult = [1];

        $this->newsRepositoryMock
            ->expects($this->any())
            ->method('fetchIdsByFilters')
            ->with($this->equalTo($filters))
            ->willReturn($values);

        $this->assertEquals($expectedResult, $this->sut->getNewsIdsByFilters($filters));
    }

}