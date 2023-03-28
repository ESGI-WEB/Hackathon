<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ApiResource]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\ManyToMany(targetEntity: Content::class, mappedBy: 'likes')]
    private Collection $likedContents;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Opinion::class, orphanRemoval: true)]
    private Collection $opinions;

    #[ORM\ManyToMany(targetEntity: Opinion::class, mappedBy: 'likes')]
    private Collection $likedOpinions;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Content::class, orphanRemoval: true)]
    private Collection $contents;


    public function __construct()
    {
        $this->likedContents = new ArrayCollection();
        $this->opinions = new ArrayCollection();
        $this->likedOpinions = new ArrayCollection();
        $this->contents = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $opinion->setAuthor($this);
        }

        return $this;
    }

    public function removeOpinion(Opinion $opinion): self
    {
        if ($this->opinions->removeElement($opinion)) {
            // set the owning side to null (unless already changed)
            if ($opinion->getAuthor() === $this) {
                $opinion->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getLikedContents(): Collection
    {
        return $this->likedContents;
    }

    public function addContent(Content $content): self
    {
        if (!$this->likedContents->contains($content)) {
            $this->likedContents[] = $content;
            $content->addLike($this);
        }

        return $this;
    }

    public function removeContent(Content $content): self
    {
        if ($this->likedContents->removeElement($content)) {
            $content->removeLike($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Opinion>
     */
    public function getLikedOpinions(): Collection
    {
        return $this->likedOpinions;
    }

    public function addLikedOpinion(Opinion $likedOpinion): self
    {
        if (!$this->likedOpinions->contains($likedOpinion)) {
            $this->likedOpinions[] = $likedOpinion;
            $likedOpinion->addLike($this);
        }

        return $this;
    }

    public function removeLikedOpinion(Opinion $likedOpinion): self
    {
        if ($this->likedOpinions->removeElement($likedOpinion)) {
            $likedOpinion->removeLike($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Content>
     */
    public function getContents(): Collection
    {
        return $this->contents;
    }
}
