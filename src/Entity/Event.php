<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\EventRepository")
 * @Vich\Uploadable()
 */
class Event
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
    private $name;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Time;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
 * @ORM\Column(type="string", length=200)
 */
private $thumbnail;

/**
 * @Vich\UploadableField(mapping="thumbnails", fileNameProperty="thumbnail")
 */
private $ThumbnailFile;

/**
 * @ORM\Column(type="string", length=255)
 */
private $Place;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;

        return $this;
    }

    public function getTime(): ?string
    {
        return $this->Time;
    }

    public function setTime(string $Time): self
    {
        $this->Time = $Time;

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
    public function setThumbnailFile($ThumbnailFile):void
    {
        $this->ThumbnailFile = $ThumbnailFile;
        if ($ThumbnailFile)
        {$this->UpdatedAt = new \DateTime();}
    }
  
  
    function __construct()
    {
    $this->PostedAt = new \DateTime();
    $this->UpdatedAt = new \DateTime();
    
    }

    public function getPlace(): ?string
    {
        return $this->Place;
    }

    public function setPlace(string $Place): self
    {
        $this->Place = $Place;

        return $this;
    }
}
