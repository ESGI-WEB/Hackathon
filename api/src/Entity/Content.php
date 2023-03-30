<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\ContentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ContentRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(),
        new Get(),
        new Post(),
        new Put(),
        new Delete(),
        new Post(
            uriTemplate: '/contents/search',
            inputFormats: ['json'],
            outputFormats: ['json'],
            requirements: [
                'Content' => 'search',
            ],
            controller: 'App\Controller\ContentSearchController',
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [
                            'schema' => [
                                'type' => 'object',
                                'properties' => [
                                    'name' => [
                                        'type' => 'string',
                                        'example' => 'Omnis itaque quidem porro quam.',
                                    ],
                                    'themes' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string',
                                            'example' => '16',
                                        ],
                                    ],
                                    'status' => [
                                        'type' => 'array',
                                        'items' => [
                                            'type' => 'string',
                                            'example' => 'validated',
                                            'description' => 'validated, pending or refused',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            deserialize: false,
            name: 'search',
        ),
        new Post(
            uriTemplate: '/contents/{id}/like',
            controller: 'App\Controller\AddContentLikeController',
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [],
                    ],
                ],
            ],
            deserialize: false,
            name: 'contentLike',
        ),
        new Post(
            uriTemplate: '/contents/{id}/unlike',
            controller: 'App\Controller\RemoveContentLikeController',
            openapiContext: [
                'requestBody' => [
                    'content' => [
                        'application/json' => [],
                    ],
                ],
            ],
            deserialize: false,
            name: 'contentUnlike',
        ),
    ],
    normalizationContext: ['groups' => ['read:content']],
)]
class Content
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['read:content'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['read:content'])]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    #[Groups(['read:content'])]
    private ?string $status = null;

    #[ORM\OneToMany(mappedBy: 'content', targetEntity: Media::class, orphanRemoval: true)]
    #[Groups(['read:content'])]
    private Collection $media;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'likedContents')]
    #[Groups(['read:content'])]
    private Collection $likes;

    #[ORM\OneToMany(mappedBy: 'content', targetEntity: Opinion::class, orphanRemoval: true)]
    #[Groups(['read:content'])]
    private Collection $opinions;

    #[ORM\ManyToOne(inversedBy: 'contents')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read:content'])]
    private ?User $author = null;

    #[ORM\ManyToMany(targetEntity: Theme::class, mappedBy: 'contents')]
    #[Groups(['read:content'])]
    private Collection $themes;

    #[ORM\Column(length: 255)]
    #[Groups(['read:content'])]
    private ?string $description = null;

    public function __construct()
    {
        $this->media = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

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

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedia(Media $media): self
    {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
            $media->setContent($this);
        }

        return $this;
    }

    public function removeMedia(Media $media): self
    {
        if ($this->media->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getContent() === $this) {
                $media->setContent(null);
            }
        }

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

    /**
     * @return Collection<int, Opinion>
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    public function addOpinion(Opinion $opinion): self
    {
        if (!$this->opinions->contains($opinion)) {
            $this->opinions[] = $opinion;
            $opinion->setContent($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getContent() === $this) {
                $opinion->setContent(null);
            }
        }

        return $this;
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

    /**
     * @return Collection<int, Theme>
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
            $theme->addCOntent($this);
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        if ($this->themes->removeElement($theme)) {
            $theme->removeCOntent($this);
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
