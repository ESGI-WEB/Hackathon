<?php

namespace App\DataFixtures;

use App\Entity\Content;
use App\Entity\Opinion;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OpinionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $contents = $manager->getRepository(Content::class)->findAll();

        for ($i = 0; $i < 60; $i++) {
            $product = (new Opinion())
                ->setAuthor($faker->randomElement($users))
                ->setContent($faker->randomElement($contents))
                ->setText($faker->text($faker->numberBetween(100, 500)))
                ->setCreatedAt(new \DateTime())
                ->addLike($faker->randomElement($users))
            ;
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            ContentFixtures::class,
        ];
    }
}
