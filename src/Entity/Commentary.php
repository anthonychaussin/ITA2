<?php

namespace App\Entity;

use App\Repository\CommentaryRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
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
     * @ORM\Column(type="string", length=5000)
     */
    private $Text;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="commentaries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $User;

    /**
     * @ORM\ManyToOne(targetEntity=Post::class, inversedBy="commentaries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Post;

    /**
     * @ORM\Column(type="datetime")
     */
    private $Date;

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

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(?User $User): self
    {
        $this->User = $User;

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

    public function getDate(): ?DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function __toString()
    {
        return $this->getText();
    }
}
