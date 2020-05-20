<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommentaryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=CommentaryRepository::class)
 */
class Commentary
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=1500)
     */
    private $Text;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="commentaries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Post;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="Commentary_Write")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=Like::class, mappedBy="Commentary", orphanRemoval=true)
     */
    private $likes;

    /**
     * @ORM\OneToMany(targetEntity=DisLike::class, mappedBy="Commentary", orphanRemoval=true)
     */
    private $disLikes;


    public function __construct()
    {
        $this->likes = new ArrayCollection();
        $this->disLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getPost(): ?Post
    {
        return $this->Post;
    }

    public function setPost(?Post $Post): self
    {
        $this->Post = $Post;

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
            $like->setCommentary($this);
        }

        return $this;
    }

    public function removeLike(Like $like): self
    {
        if ($this->likes->contains($like)) {
            $this->likes->removeElement($like);
            // set the owning side to null (unless already changed)
            if ($like->getCommentary() === $this) {
                $like->setCommentary(null);
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
            $disLike->setCommentary($this);
        }

        return $this;
    }

    public function removeDisLike(DisLike $disLike): self
    {
        if ($this->disLikes->contains($disLike)) {
            $this->disLikes->removeElement($disLike);
            // set the owning side to null (unless already changed)
            if ($disLike->getCommentary() === $this) {
                $disLike->setCommentary(null);
            }
        }

        return $this;
    }

}
