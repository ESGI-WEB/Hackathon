<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\OpinionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation\Timestampable;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: OpinionRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(
            uriTemplate: '/opinions',
            inputFormats: ['json'],
            outputFormats: ['json'],
            controller: 'App\Controller\CreateOpinionController',
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'text' => [
                                        'type' => 'string',
                                        'example' => 'Omnis itaque quidem porro quam.',
                                    ],
                                    'content' => [
                                        'type' => 'integer',
                                        'example' => 5,
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            deserialize: false,
            name: 'createOpinion',
        ),
        new Put(),
        new Delete(),
        new Post(
            uriTemplate: '/opinions/{id}/like',
            controller: 'App\Controller\AddLikeOpinionController',
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [],
                    ],
                ],
            ],
            deserialize: false,
            name: 'opinionLike',
        ),
        new Post(
            uriTemplate: '/opinions/{id}/unlike',
            controller: 'App\Controller\RemoveLikeOpinionController',
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [],
                    ],
                ],
            ],
            deserialize: false,
            name: 'opinionUnlike',
        )
    ],
    normalizationContext: ['groups' => ['read:opinion']],
)]
class Opinion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['read:content', 'read:opinion'])]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'opinions')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:content', 'read:opinion'])]
    private ?User $author = null;

    #[ORM\Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
    #[Timestampable(on: 'create')]
    #[Groups(['read:content', 'read:opinion'])]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Length(min: 100)]
    #[Groups(['read:content', 'read:opinion'])]
    private ?string $text = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'likedOpinions')]
    #[Groups(['read:content', 'read:opinion'])]
    private Collection $likes;

    #[ORM\ManyToOne(inversedBy: 'opinions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Content $content = null;

    public function __construct()
    {
        $this->likes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(User $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
        }

        return $this;
    }

    public function removeLike(User $like): self
    {
        $this->likes->removeElement($like);

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
}
