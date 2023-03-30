<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Controller\CreateMediaObjectAction;
use App\Repository\MediaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[Vich\Uploadable]
#[ApiResource(
    types: ['https://schema.org/MediaObject'],
    operations: [
        new Get(),
        new GetCollection(),
        new Put(),
        new Delete(),
        new Patch(),
        new Post(
            controller: CreateMediaObjectAction::class,
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'file' => [
                                        'type' => 'string',
                                        'format' => 'binary',
                                    ],
                                    'name' => [
                                        'type' => 'string',
                                    ],
                                    'description' => [
                                        'type' => 'string',
                                    ],
                                    'content' => [
                                        'type' => 'integer',
                                        'description' => 'Content id',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            deserialize: false
        )
    ],
    normalizationContext: ['groups' => ['media_object:read']]
)]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['read:content'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 100)]
    #[Groups(['read:content'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['read:content'])]
    private ?string $description = null;

    #[Assert\File(
        maxSize: '2M',
    )]
    #[Vich\UploadableField(mapping: "media_object", fileNameProperty: "path")]
    #[Groups(['read:content'])]
    public ?File $file = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['read:content'])]
    private ?string $path = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Content $content = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:content'])]
    private ?TypeMedia $type = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getContent(): ?Content
    {
        return $this->content;
    }

    public function setContent(?Content $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getType(): ?TypeMedia
    {
        return $this->type;
    }

    public function setType(?TypeMedia $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function setFile(File $file = null): void
    {
        $this->file = $file;
    }
}
