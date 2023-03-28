<?php

namespace App\DataFixtures;

use App\Entity\Content;
use App\Entity\Theme;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class ThemeFixtures extends Fixture  implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $users = $manager->getRepository(User::class)->findAll();
        $contents = $manager->getRepository(Content::class)->findAll();

        $theme = (new Theme())
            ->setName('Remboursement')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Naissance')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Décès')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Accident domestique')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Accident du travail')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Psychologie')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Arrêt maladie')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $theme = (new Theme())
            ->setName('Bien-être')
            ->addTargetedUser($faker->randomElement($users))
            ->addContent($faker->randomElement($contents));
        $manager->persist($theme);

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            UserFixtures::class,
            ContentFixtures::class,
        );
    }
}
