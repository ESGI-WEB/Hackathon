<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ThemeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ThemeRepository::class)]
#[ApiResource]
class Theme
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    #[Groups(['read:content'])]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['read:content'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'themes')]
    private Collection $targetedUsers;

    #[ORM\ManyToMany(targetEntity: Content::class, inversedBy: 'themes')]
    private Collection $contents;

    public function __construct()
    {
        $this->targetedUsers = new ArrayCollection();
        $this->contents = new ArrayCollection();
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

    /**
     * @return Collection<int, User>
     */
    public function getTargetedUsers(): Collection
    {
        return $this->targetedUsers;
    }

    public function addTargetedUser(User $targetedUser): self
    {
        if (!$this->targetedUsers->contains($targetedUser)) {
            $this->targetedUsers[] = $targetedUser;
        }

        return $this;
    }

    public function removeTargetedUser(User $targetedUser): self
    {
        $this->targetedUsers->removeElement($targetedUser);

        return $this;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->contents->contains($content)) {
            $this->contents[] = $content;
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        $this->contents->removeElement($content);

        return $this;
    }
}
