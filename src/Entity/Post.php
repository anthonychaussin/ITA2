<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=PostRepository::class)
 */
class Post
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=500)
     */
    private $Ressource;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    /**
     * @ORM\OneToMany(targetEntity=Commentary::class, mappedBy="Post", orphanRemoval=true)
     */
    private $commentaries;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Post")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="Approuve")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Approuve::class, mappedBy="Post", orphanRemoval=true)
     */
    private $approuves;

    /**
     * @ORM\OneToMany(targetEntity=DisApprouve::class, mappedBy="Post", orphanRemoval=true)
     */
    private $disApprouves;

    public function __construct()
    {
        $this->commentaries = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->approuves = new ArrayCollection();
        $this->disApprouves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getRessource(): ?string
    {
        return $this->Ressource;
    }

    public function setRessource(string $Ressource): self
    {
        $this->Ressource = $Ressource;

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->Type;
    }

    public function setType(?Type $Type): self
    {
        $this->Type = $Type;

        return $this;
    }

    /**
     * @return Collection|Commentary[]
     */
    public function getCommentaries(): Collection
    {
        return $this->commentaries;
    }

    public function addCommentary(Commentary $commentary): self
    {
        if (!$this->commentaries->contains($commentary)) {
            $this->commentaries[] = $commentary;
            $commentary->setPost($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->contains($commentary)) {
            $this->commentaries->removeElement($commentary);
            // set the owning side to null (unless already changed)
            if ($commentary->getPost() === $this) {
                $commentary->setPost(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addApprouve($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
            $user->removeApprouve($this);
        }

        return $this;
    }

    /**
     * @return Collection|Approuve[]
     */
    public function getApprouves(): Collection
    {
        return $this->approuves;
    }

    public function addApproufe(Approuve $approufe): self
    {
        if (!$this->approuves->contains($approufe)) {
            $this->approuves[] = $approufe;
            $approufe->setPost($this);
        }

        return $this;
    }

    public function removeApproufe(Approuve $approufe): self
    {
        if ($this->approuves->contains($approufe)) {
            $this->approuves->removeElement($approufe);
            // set the owning side to null (unless already changed)
            if ($approufe->getPost() === $this) {
                $approufe->setPost(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DisApprouve[]
     */
    public function getDisApprouves(): Collection
    {
        return $this->disApprouves;
    }

    public function addDisApproufe(DisApprouve $disApproufe): self
    {
        if (!$this->disApprouves->contains($disApproufe)) {
            $this->disApprouves[] = $disApproufe;
            $disApproufe->setPost($this);
        }

        return $this;
    }

    public function removeDisApproufe(DisApprouve $disApproufe): self
    {
        if ($this->disApprouves->contains($disApproufe)) {
            $this->disApprouves->removeElement($disApproufe);
            // set the owning side to null (unless already changed)
            if ($disApproufe->getPost() === $this) {
                $disApproufe->setPost(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
