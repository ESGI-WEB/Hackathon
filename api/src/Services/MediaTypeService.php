<?php

namespace App\Services;


use App\Entity\TypeMedia;
use App\Repository\TypeMediaRepository;

class MediaTypeService implements MediaTypeServiceInterface
{
    private TypeMediaRepository $typeMediaRepository;

    public function __construct(TypeMediaRepository $typeMediaRepository)
    {
        $this->typeMediaRepository = $typeMediaRepository;
    }

    public function getFileExtensions(): array
    {
        return ['pdf', 'doc', 'docx', 'txt'];
    }

    public function getImageExtensions(): array
    {
        return ['jpg', 'jpeg', 'png', 'gif'];
    }

    public function getVideoExtensions(): array
    {
        return ['mp4', 'avi', 'mov', 'mkv'];
    }

    public function getSoundExtensions(): array
    {
        return ['mp3', 'wav', 'ogg'];
    }

    public function getMediaType(string $extension): ?TypeMedia
    {
        $slug = null;
        if (in_array($extension, $this->getImageExtensions())) {
            $slug = 'image';
        } elseif (in_array($extension, $this->getVideoExtensions())) {
            $slug = 'video';
        } elseif (in_array($extension, $this->getSoundExtensions())) {
            $slug = 'podcast';
        } elseif (in_array($extension, $this->getFileExtensions())) {
            $slug = 'file';
        }

        return $slug ? $this->typeMediaRepository->findOneBy(['slug' => $slug]) : null;
    }

    public function getAllExtensions(): array
    {
        return array_merge(
            $this->getFileExtensions(),
            $this->getImageExtensions(),
            $this->getVideoExtensions(),
            $this->getSoundExtensions()
        );
    }
}
