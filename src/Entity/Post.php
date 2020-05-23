<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PostRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     itemOperations={"get", "delete", "put", "patch", "archive"={"route_name"="api_post_archive"}},
 * )
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
    private $Title;

    /**
     * @ORM\Column(type="string", length=1500)
     */
    private $Ressource;

    /**
     * @ORM\ManyToOne(targetEntity=Type::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="posts")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

    /**
     * @ORM\OneToMany(targetEntity=Commentary::class, mappedBy="Post", orphanRemoval=true)
     */
    private $commentaries;

    /**
     * @ORM\OneToMany(targetEntity=Approuve::class, mappedBy="Post", orphanRemoval=true)
     */
    private $approuves;

    /**
     * @ORM\OneToMany(targetEntity=DisApprouve::class, mappedBy="Post", orphanRemoval=true)
     */
    private $disApprouves;

    /**
     * @ORM\OneToMany(targetEntity=LikeP::class, mappedBy="Post", orphanRemoval=true)
     */
    private $likePs;

    /**
     * @ORM\OneToMany(targetEntity=DisLikeP::class, mappedBy="Post", orphanRemoval=true)
     */
    private $disLikePs;

    public function __construct()
    {
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

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    public function getDate(): ?DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(DateTimeInterface $Date): self
    {
        $this->Date = $Date;

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
            $likeP->setPost($this);
        }

        return $this;
    }

    public function removeLikeP(LikeP $likeP): self
    {
        if ($this->likePs->contains($likeP)) {
            $this->likePs->removeElement($likeP);
            // set the owning side to null (unless already changed)
            if ($likeP->getPost() === $this) {
                $likeP->setPost(null);
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
            $disLikeP->setPost($this);
        }

        return $this;
    }

    public function removeDisLikeP(DisLikeP $disLikeP): self
    {
        if ($this->disLikePs->contains($disLikeP)) {
            $this->disLikePs->removeElement($disLikeP);
            // set the owning side to null (unless already changed)
            if ($disLikeP->getPost() === $this) {
                $disLikeP->setPost(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
}
