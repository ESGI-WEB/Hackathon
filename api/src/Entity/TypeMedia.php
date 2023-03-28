<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\TypeMediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ApiResource]
#[ORM\Entity(repositoryClass: TypeMediaRepository::class)]
class TypeMedia
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 30)]
    private ?string $name = null;

    #[ORM\Column(type: Types::ARRAY, nullable: true)]
    private array $extensions = [];

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getExtensions(): array
    {
        return $this->extensions;
    }

    public function setExtensions(?array $extensions): self
    {
        $this->extensions = $extensions;

        return $this;
    }
}
