<?php

namespace App\DataFixtures;

use App\Entity\Content;
use App\Entity\Media;
use App\Entity\Opinion;
use App\Entity\TypeMedia;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class MediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $contents = $manager->getRepository(Content::class)->findAll();
        $typeImage = $manager->getRepository(TypeMedia::class)->findOneBy(['name' => 'Image']);

        for ($i = 0; $i < 60; $i++) {
            $product = (new Media())
                ->setName($faker->text($faker->numberBetween(10, 50)))
                ->setDescription($faker->text($faker->numberBetween(100, 500)))
                ->setPath('/todo')
                ->setContent($faker->randomElement($contents))
                ->setType($typeImage)
            ;
            $manager->persist($product);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ContentFixtures::class,
            TypeMediaFixtures::class
        ];
    }
}
