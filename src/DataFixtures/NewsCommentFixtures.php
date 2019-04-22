<?php /** @noinspection PhpParamsInspection */

namespace App\DataFixtures;

use App\Entity\NewsComment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\LoremIpsumBundle\KnpUIpsum;

class NewsCommentFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @var KnpUIpsum
     */
    private $knpIpsum;

    public function __construct(KnpUIpsum $knpIpsum)
    {
        $this->knpIpsum = $knpIpsum;
    }


    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 250; $i++) {
            $comment = new NewsComment();
            if ($i % 3 === 1) { // every third comment was created by logged user
                $comment->setCreatedBy($this->getReference('user-' . ($i % UserFixtures::COUNT)));
                $comment->setUpdatedBy($this->getReference('user-' . ($i % UserFixtures::COUNT)));
            } else {
                $comment->setAuthor($this->knpIpsum->getWords(($i % 3) + 1));
            }
            $comment->setNews($this->getReference('news-' . ($i % NewsFixtures::COUNT)));
            $comment->setContent($this->knpIpsum->getParagraphs(($i % 2) + 1));
            $manager->persist($comment);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            NewsFixtures::class
        ];
    }
}
