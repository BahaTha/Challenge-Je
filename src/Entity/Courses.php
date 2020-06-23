<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CoursesRepository")
 */
class Courses
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Article", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Course;

    /**
     * @ORM\Column(type="date")
     */
    private $Date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teacher;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Time;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCourse(): ?Article
    {
        return $this->Course;
    }

    public function setCourse(Article $Course): self
    {
        $this->Course = $Course;

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

    public function getTeacher(): ?string
    {
        return $this->teacher;
    }

    public function setTeacher(string $teacher): self
    {
        $this->teacher = $teacher;

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
}
