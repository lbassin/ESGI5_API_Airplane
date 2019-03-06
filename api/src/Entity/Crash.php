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
     * @ORM\OneToOne(targetEntity="App\Entity\Flight", mappedBy="crash", cascade={"persist", "remove"})
     */
    private $flight;

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

    public function getFlight(): ?Flight
    {
        return $this->flight;
    }

    public function setFlight(?Flight $flight): self
    {
        $this->flight = $flight;

        // set (or unset) the owning side of the relation if necessary
        $newCrash = $flight === null ? null : $this;
        if ($newCrash !== $flight->getCrash()) {
            $flight->setCrash($newCrash);
        }

        return $this;
    }
}
