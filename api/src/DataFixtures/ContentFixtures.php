<?php

namespace App\DataFixtures;

use App\Entity\Content;
use App\Entity\Opinion;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ContentFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 60; $i++) {
            $product = (new Content())
                ->setAuthor($faker->randomElement($users))
                ->setName($faker->text($faker->numberBetween(10, 50)))
                ->setStatus($faker->randomElement(['validated', 'pending', 'refused']))
            ;
            $manager->persist($product);
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
