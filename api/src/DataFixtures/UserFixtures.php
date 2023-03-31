<?php

namespace App\DataFixtures;

use App\Entity\Joke;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $pwd = '$2y$13$19U8JcKxqE9jNoSbVgZQ/u06ja8LcQ.31BXvCZcnqa9hPppl/lH86';

        $user = (new User())
            ->setEmail('user@user.fr')
            ->setRoles(['ROLE_USER'])
            ->setPassword($pwd)
            ->setFirstname('John')
            ->setLastname('Doe')
        ;
        $manager->persist($user);

        $admin = (new User())
            ->setEmail('admin@user.fr')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($pwd)
            ->setFirstname('Jane')
            ->setLastname('Laouf')
        ;
        $manager->persist($admin);

        $moderator = (new User())
            ->setEmail('moderator@user.fr')
            ->setRoles(['ROLE_MODERATOR'])
            ->setPassword($pwd)
            ->setFirstname('Jean')
            ->setLastname('Pouille')
        ;
        $manager->persist($moderator);

        $manager->flush();
    }
}
