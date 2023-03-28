<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use App\Entity\TypeMedia;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeMediaFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $textEditorType = (new TypeMedia())
            ->setName('Texte');
        $manager->persist($textEditorType);

        $fileType = (new TypeMedia())
            ->setName('Fichier')
            ->setExtensions(['pdf', 'doc', 'docx', 'txt']);
        $manager->persist($fileType);

        $videoType = (new TypeMedia())
            ->setName('Vidéo')
            ->setExtensions(['mp4', 'avi', 'mov', 'mkv']);
        $manager->persist($videoType);

        $imageType = (new TypeMedia())
            ->setName('Image')
            ->setExtensions(['jpg', 'jpeg', 'png', 'gif']);
        $manager->persist($imageType);

        $soundType = (new TypeMedia())
            ->setName('Podcast')
            ->setExtensions(['mp3', 'wav', 'ogg']);
        $manager->persist($soundType);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class
        ];
    }
}
