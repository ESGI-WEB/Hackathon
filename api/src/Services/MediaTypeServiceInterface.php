<?php

namespace App\Services;

use App\Entity\TypeMedia;

interface MediaTypeServiceInterface
{
    public function getFileExtensions(): array;
    public function getImageExtensions(): array;
    public function getVideoExtensions(): array;
    public function getSoundExtensions(): array;

    public function getMediaType(string $extension): ?TypeMedia;
    public function getAllExtensions(): array;
}
