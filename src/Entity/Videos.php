<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UploaderBundle\Mapping\Annotation\UploadableField;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass="App\Repository\VideosRepository")
 * @Vich\Uploadable()
 */
class Videos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
 * @ORM\Column(type="string", length=200)
 */
private $thumbnail;

    /**
     * @ORM\Column(type="string", length=255)
     * @ORM\JoinColumn(nullable=false)
     */
    private $Slug;
     /**
     * @Vich\UploadableField(mapping="videos", fileNameProperty="thumbnail")
     * @Assert\File(maxSize="2147483648")
     */
    private $ThumbnailFile;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User5", inversedBy="videos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $Author;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Article", inversedBy="videos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $Subject;

    function __construct()
    {
    $this->CreatedAt = new \DateTime(); 
    
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): ?string
    {
        return $this->Slug;
    }

    public function setSlug(string $Slug): self
    {
        $this->Slug = $Slug;

        return $this;
    }

    public function getAuthor(): ?User5
    {
        return $this->Author;
    }

    public function setAuthor(?User5 $Author): self
    {
        $this->Author = $Author;

        return $this;
    }

    public function getSubject(): ?Article
    {
        return $this->Subject;
    }

    public function setSubject(?Article $Subject): self
    {
        $this->Subject = $Subject;

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
     * @param mixed $ThumbnailFile
     */
    public function setThumbnailFile(?File $ThumbnailFile):void
    {
        $this->ThumbnailFile = $ThumbnailFile;
        if ($ThumbnailFile)
        {$this->UpdatedAt = new \DateTime();}
    }
     /**
     * @return mixed
     */
    public function getThumbnailFile ()
    {
        return $this->ThumbnailFile;
    }
    
    
}
