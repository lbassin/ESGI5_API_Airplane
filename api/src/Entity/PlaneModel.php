<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\PlaneModelRepository")
 */
class PlaneModel
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
     * @ORM\Column(type="integer")
     */
    private $places;

    /**
     * @ORM\Column(type="integer")
     */
    private $gazoline;

    /**
     * @ORM\Column(type="float")
     */
    private $reliabilitÃy;

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

    public function getPlaces(): ?int
    {
        return $this->places;
    }

    public function setPlaces(int $places): self
    {
        $this->places = $places;

        return $this;
    }

    public function getGazoline(): ?int
    {
        return $this->gazoline;
    }

    public function setGazoline(int $gazoline): self
    {
        $this->gazoline = $gazoline;

        return $this;
    }

    public function getReliabilitÃy(): ?float
    {
        return $this->reliabilitÃy;
    }

    public function setReliabilitÃy(float $reliabilitÃy): self
    {
        $this->reliabilitÃy = $reliabilitÃy;

        return $this;
    }
}
