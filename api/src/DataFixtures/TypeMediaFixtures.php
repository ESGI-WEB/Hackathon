<?php

namespace App\DataFixtures;

use App\Entity\Opinion;
use App\Entity\TypeMedia;
use App\Entity\User;
use App\Services\MediaTypeServiceInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TypeMediaFixtures extends Fixture
{
    private MediaTypeServiceInterface $mediaTypeService;

    public function __construct(MediaTypeServiceInterface $mediaTypeService)
    {
        $this->mediaTypeService = $mediaTypeService;
    }

    public function load(ObjectManager $manager): void
    {
        $textEditorType = (new TypeMedia())
            ->setName('Texte')
            ->setSlug('text');
        $manager->persist($textEditorType);

        $fileType = (new TypeMedia())
            ->setName('Fichier')
            ->setSlug('file')
            ->setExtensions($this->mediaTypeService->getFileExtensions());
        $manager->persist($fileType);

        $videoType = (new TypeMedia())
            ->setName('Vidéo')
            ->setSlug('video')
            ->setExtensions($this->mediaTypeService->getVideoExtensions());
        $manager->persist($videoType);

        $imageType = (new TypeMedia())
            ->setName('Image')
            ->setSlug('image')
            ->setExtensions($this->mediaTypeService->getImageExtensions());
        $manager->persist($imageType);

        $soundType = (new TypeMedia())
            ->setName('Podcast')
            ->setSlug('podcast')
            ->setExtensions($this->mediaTypeService->getSoundExtensions());
        $manager->persist($soundType);

        $manager->flush();
    }
}
