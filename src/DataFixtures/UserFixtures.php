<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const COUNT = 10;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;


    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }


    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < self::COUNT; $i++) {
            $user = new User();
            $user->setEmail('user' . $i . '@example.com');
            $user->setPassword($this->passwordEncoder->encodePassword($user, 'user' . $i));
            $this->addReference('user-' . $i, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }
}
