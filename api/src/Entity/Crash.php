<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\CrashRepository")
 */
class Crash
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
    private $date;

    /**
     * @ORM\Column(type="boolean")
     */
    private $found;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Plane", inversedBy="crash", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $plane;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getFound(): ?bool
    {
        return $this->found;
    }

    public function setFound(bool $found): self
    {
        $this->found = $found;

        return $this;
    }

    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    public function setPlane(Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }
}
