<?php /** @noinspection PhpParamsInspection */

namespace App\DataFixtures;

use App\Entity\News;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use KnpU\LoremIpsumBundle\KnpUIpsum;

class NewsFixtures extends Fixture implements DependentFixtureInterface
{
    const COUNT = 50;

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
        for ($i = 0; $i < self::COUNT; $i++) {
            $news = new News();
            $news->setCreatedBy($this->getReference('user-' . ($i % UserFixtures::COUNT)));
            $news->setUpdatedBy($this->getReference('user-' . ($i % UserFixtures::COUNT)));
            $news->setTitle(substr($this->knpIpsum->getSentences(), 0, 255));
            $news->setContent($this->knpIpsum->getParagraphs(($i % 5) + 2));
            $manager->persist($news);
            $this->addReference('news-' . $i, $news);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
