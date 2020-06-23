<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Comment
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $art;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User5", inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;
    /**
     * @ORM\PrePersist
     *
     * @return void
     */
    public function prePersist()
    {if (empty($this->CreatedAt))
    $this->CreatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getArt(): ?article
    {
        return $this->art;
    }

    public function setArt(?article $art): self
    {
        $this->art = $art;

        return $this;
    }

    public function getAuthor(): ?User5
    {
        return $this->author;
    }

    public function setAuthor(?User5 $author): self
    {
        $this->author = $author;

        return $this;
    }
}
