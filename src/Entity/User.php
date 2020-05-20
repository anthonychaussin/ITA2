<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="user", orphanRemoval=true)
     */
    private $Post;

    /**
     * @ORM\OneToMany(targetEntity=Approuve::class, mappedBy="User", orphanRemoval=true)
     */
    private $approuves;

    /**
     * @ORM\OneToMany(targetEntity=DisApprouve::class, mappedBy="User", orphanRemoval=true)
     */
    private $disApprouves;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="User", orphanRemoval=true)
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=DisLike::class, mappedBy="User", orphanRemoval=true)
     */
    private $disLikes;


    public function __construct()
    {
        $this->Post = new ArrayCollection();
        $this->approuves = new ArrayCollection();
        $this->disApprouves = new ArrayCollection();
        $this->likes = new ArrayCollection();
        $this->disLikes = new ArrayCollection();
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
    public function getUsername(): string
    {
        return (string)$this->email;
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
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string)$this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
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
     * @return Collection|Post[]
     */
    public function getPost(): Collection
    {
        return $this->Post;
    }

    public function addPost(Post $post): self
    {
        if (!$this->Post->contains($post)) {
            $this->Post[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->Post->contains($post)) {
            $this->Post->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
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
            $approufe->setUser($this);
        }

        return $this;
    }

    public function removeApproufe(Approuve $approufe): self
    {
        if ($this->approuves->contains($approufe)) {
            $this->approuves->removeElement($approufe);
            // set the owning side to null (unless already changed)
            if ($approufe->getUser() === $this) {
                $approufe->setUser(null);
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
            $disApproufe->setUser($this);
        }

        return $this;
    }

    public function removeDisApproufe(DisApprouve $disApproufe): self
    {
        if ($this->disApprouves->contains($disApproufe)) {
            $this->disApprouves->removeElement($disApproufe);
            // set the owning side to null (unless already changed)
            if ($disApproufe->getUser() === $this) {
                $disApproufe->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Like[]
     */
    public function getLikes(): Collection
    {
        return $this->likes;
    }

    public function addLike(Like $like): self
    {
        if (!$this->likes->contains($like)) {
            $this->likes[] = $like;
            $like->setUser($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getUser() === $this) {
                $like->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DisLike[]
     */
    public function getDisLikes(): Collection
    {
        return $this->disLikes;
    }

    public function addDisLike(DisLike $disLike): self
    {
        if (!$this->disLikes->contains($disLike)) {
            $this->disLikes[] = $disLike;
            $disLike->setUser($this);
        }

        return $this;
    }

    public function removeDisLike(DisLike $disLike): self
    {
        if ($this->disLikes->contains($disLike)) {
            $this->disLikes->removeElement($disLike);
            // set the owning side to null (unless already changed)
            if ($disLike->getUser() === $this) {
                $disLike->setUser(null);
            }
        }

        return $this;
    }

}
