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
     * @ORM\OneToMany(targetEntity=Post::class, mappedBy="User", orphanRemoval=true)
     */
    private $posts;

    /**
     * @ORM\OneToMany(targetEntity=Commentary::class, mappedBy="User", orphanRemoval=true)
     */
    private $commentaries;

    /**
     * @ORM\OneToMany(targetEntity=Approuve::class, mappedBy="User", orphanRemoval=true)
     */
    private $approuves;

    /**
     * @ORM\OneToMany(targetEntity=DisApprouve::class, mappedBy="User", orphanRemoval=true)
     */
    private $disApprouves;

    /**
     * @ORM\OneToMany(targetEntity=LikeP::class, mappedBy="User", orphanRemoval=true)
     */
    private $likePs;

    /**
     * @ORM\OneToMany(targetEntity=DisLikeP::class, mappedBy="User", orphanRemoval=true)
     */
    private $disLikePs;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->commentaries = new ArrayCollection();
        $this->approuves = new ArrayCollection();
        $this->disApprouves = new ArrayCollection();
        $this->likePs = new ArrayCollection();
        $this->disLikePs = new ArrayCollection();
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
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts[] = $post;
            $post->setUser($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->contains($post)) {
            $this->posts->removeElement($post);
            // set the owning side to null (unless already changed)
            if ($post->getUser() === $this) {
                $post->setUser(null);
            }
        }

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
            $commentary->setUser($this);
        }

        return $this;
    }

    public function removeCommentary(Commentary $commentary): self
    {
        if ($this->commentaries->contains($commentary)) {
            $this->commentaries->removeElement($commentary);
            // set the owning side to null (unless already changed)
            if ($commentary->getUser() === $this) {
                $commentary->setUser(null);
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
     * @return Collection|LikeP[]
     */
    public function getLikePs(): Collection
    {
        return $this->likePs;
    }

    public function addLikeP(LikeP $likeP): self
    {
        if (!$this->likePs->contains($likeP)) {
            $this->likePs[] = $likeP;
            $likeP->setUser($this);
        }

        return $this;
    }

    public function removeLikeP(LikeP $likeP): self
    {
        if ($this->likePs->contains($likeP)) {
            $this->likePs->removeElement($likeP);
            // set the owning side to null (unless already changed)
            if ($likeP->getUser() === $this) {
                $likeP->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|DisLikeP[]
     */
    public function getDisLikePs(): Collection
    {
        return $this->disLikePs;
    }

    public function addDisLikeP(DisLikeP $disLikeP): self
    {
        if (!$this->disLikePs->contains($disLikeP)) {
            $this->disLikePs[] = $disLikeP;
            $disLikeP->setUser($this);
        }

        return $this;
    }

    public function removeDisLikeP(DisLikeP $disLikeP): self
    {
        if ($this->disLikePs->contains($disLikeP)) {
            $this->disLikePs->removeElement($disLikeP);
            // set the owning side to null (unless already changed)
            if ($disLikeP->getUser() === $this) {
                $disLikeP->setUser(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getEmail();
    }
}
