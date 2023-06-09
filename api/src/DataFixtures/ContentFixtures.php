<?php

namespace App\DataFixtures;

use App\Entity\Content;
use App\Entity\Opinion;
use App\Entity\Status;
use App\Entity\Theme;
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
        $themes = $manager->getRepository(Theme::class)->findAll();

        for ($i = 0; $i < 60; $i++) {
            $product = (new Content())
                ->setAuthor($faker->randomElement($users))
                ->setName($faker->text($faker->numberBetween(10, 50)))
                ->addTheme($faker->randomElement($themes))
                ->setDescription($faker->text($faker->numberBetween(50, 200)))
                ->setStatus($faker->randomElement([Status::VALIDATED, Status::PENDING, Status::REJECTED]))
            ;

            for ($j = 0; $j < $faker->numberBetween(0, 10); $j++) {
                $product->addLike($faker->randomElement($users));
            }
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            ThemeFixtures::class,
        ];
    }
}
