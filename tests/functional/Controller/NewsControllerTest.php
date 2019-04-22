<?php namespace App\Tests\Controller;

use App\Entity\News;

class NewsControllerTest extends \Codeception\Test\Unit
{
    /**
     * @var \App\Tests\FunctionalTester
     */
    protected $tester;

    public function testNewsList()
    {
        $newsList = $this->tester->getEm()->getRepository(News::class)->findAll();

        $this->tester->amOnPage("/");
        $this->tester->see('Showing ' . count($newsList) . ' news');
        foreach ($newsList as $news) {
            $this->tester->see($news->getTitle(), 'h1');

            // we will check each paragraph separately
            // @todo call symfony nl2br on $news->content and then check if it exists in page content
            $parts = explode("\n", $news->getContent());
            foreach ($parts as $part) {
                if ($part) {
                    $this->tester->see($part);
                }
            }
        }
        $this->markTestIncomplete('@todo test if single news contains all required information - createdBy, updatedAt etc.');
        $this->markTestIncomplete('@todo also test if news are ordered by date desc');
    }

    public function testNewsDetails()
    {
        list($news1, $news2) = $this->tester->getEm()->getRepository(News::class)->findBy([], ['createdAt' => 'desc', 'id' => 'desc'], 2);
        $this->tester->amOnPage("/");
        $this->tester->click($news1->getTitle());
        $this->tester->seeInCurrentUrl('/news/' . $news1->getId());
        $this->tester->see($news1->getTitle());
        $this->tester->dontSee($news2->getTitle());
        $this->markTestIncomplete('@todo test all news details');
        $this->markTestIncomplete('@todo test news comments');
    }

    public function testCantAddNewsNotLogged()
    {
        $this->tester->amOnPage('/');
        $this->tester->dontSeeLink('Add news');

        $this->tester->amOnPage('news/new');
        $this->tester->seeInCurrentUrl('/login');
    }

    public function testAddNews()
    {
        $lastNews = $this->getLastNews();

        $this->tester->amAuthenticated();
        $this->tester->amOnPage('/');
        $this->tester->seeLink('Add news');
        $this->tester->click('Add news');

        $this->tester->submitForm('form', [
            'news[title]' => 'Example news 123',
            'news[content]' => 'Example news content 123'
        ], 'Create');


        $this->tester->seeResponseCodeIsSuccessful();

        $newNews = $this->getLastNews();

        $this->assertNotEquals($lastNews->getId(), $newNews->getId());

        $this->tester->seeInCurrentUrl('/news/' . $newNews->getId());

        $this->tester->see($newNews->getTitle(), 'h1');
        $this->tester->see($newNews->getContent());
        $this->tester->see($newNews->getCreatedBy(), 'footer');
        $this->tester->see($newNews->getCreatedAt()->format('Y-m-d H:i'), 'footer');
    }

    /**
     * @return News|object|null
     */
    private function getLastNews()
    {
        return $this->tester->getEm()->getRepository(News::class)->findOneBy([], ['createdAt' => 'desc', 'id' => 'desc'], 2);
    }

    public function testEditNews()
    {
        $this->markTestIncomplete('@todo');
    }

    protected function _before()
    {
    }

    protected function _after()
    {
    }
}