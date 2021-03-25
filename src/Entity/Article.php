<?php

namespace App\Entity;



use App\Entity\User5;
use App\Entity\Videos;
use App\Entity\Category;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 * @Vich\Uploadable()
 */
class Article
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

      /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
     
    private $PostedAt;

        /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $UpdatedAt;

      /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\ManyToOne(targetEntity="App\Entity\User5", inversedBy="Articles")
     */
    private $Author;


    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="float")
     */
    private $Price;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    
    
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;


/**
 * @ORM\Column(type="string", length=200)
 */
    private $thumbnail;

    /**
     * @Vich\UploadableField(mapping="thumbnails", fileNameProperty="thumbnail")
     */

    private $ThumbnailFile;

   


    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="art", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Videos", mappedBy="Subject" , cascade={"persist"})
     */
    private $videos;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="Articles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostedAt(): ?\DateTimeInterface
    {
        return $this->PostedAt;
    }

    public function setPostedAt(\DateTimeInterface $PostedAt): self
    {
        $this->PostedAt = $PostedAt;

        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->Author;
    }

    public function setAuthor(string $Author): self
    {
        $this->Author = $Author;

        return $this;
    }
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $Slug): self
    {
        $this->slug = $Slug;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->Price;
    }

    public function setPrice(float $Price): self
    {
        $this->Price = $Price;

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

   

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function setThumbnail(?string $thumbnail): self
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }
     /**
     * @return mixed
     */
    public function getThumbnailFile ()
    {
        return $this->ThumbnailFile;
    }
    

    /**
     * @param mixed $ThumbnailFile
     */
    public function setThumbnailFile(?File $ThumbnailFile):void
    {
        $this->ThumbnailFile = $ThumbnailFile;
        if ($ThumbnailFile)
        {$this->UpdatedAt = new \DateTime();}
    }
  
  
    function __construct()
    {
    $this->PostedAt = new \DateTime();
    $this->UpdatedAt = new \DateTime();
    $this->comments = new ArrayCollection();
    $this->videos = new ArrayCollection();
    
    }

    

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setArt($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getArt() === $this) {
                $comment->setArt(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Videos[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Videos $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setSubject($this);
        }

        return $this;
    }

    public function removeVideo(Videos $video): self
    {
        if ($this->videos->contains($video)) {
            $this->videos->removeElement($video);
            // set the owning side to null (unless already changed)
            if ($video->getSubject() === $this) {
                $video->setSubject(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?category
    {
        return $this->category;
    }

    public function setCategory(?category $category): self
    {
        $this->category = $category;

        return $this;
    }

   
    public function __toString() {
        return $this->getSlug();
      }

}
