<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"plane_model_read"}},
 *     denormalizationContext={"groups"={"plane_model_write"}}
 * )
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
     * @Groups({"plane_model_read", "plane_model_write"})
     * @Assert\NotBlank()
     * @Assert\Length(max="255")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"plane_model_read", "plane_model_write"})
     * @Assert\NotBlank()
     * @Assert\GreaterThanOrEqual(0)
     */
    private $places;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"plane_model_read", "plane_model_write"})
     * @Assert\NotBlank()
     * @Assert\GreaterThan(0)
     */
    private $gazoline;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"plane_model_read"})
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(100)
     */
    private $reliability;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plane", mappedBy="model", orphanRemoval=true)
     */
    private $planes;

    public function __construct()
    {
        $this->planes = new ArrayCollection();
    }

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

    public function getReliability(): ?float
    {
        return $this->reliability;
    }

    public function setReliability(?float $reliability): self
    {
        $this->reliability = $reliability;

        return $this;
    }

    /**
     * @return Collection|Plane[]
     */
    public function getPlanes(): Collection
    {
        return $this->planes;
    }

    public function addPlane(Plane $plane): self
    {
        if (!$this->planes->contains($plane)) {
            $this->planes[] = $plane;
            $plane->setModel($this);
        }

        return $this;
    }

    public function removePlane(Plane $plane): self
    {
        if ($this->planes->contains($plane)) {
            $this->planes->removeElement($plane);
            // set the owning side to null (unless already changed)
            if ($plane->getModel() === $this) {
                $plane->setModel(null);
            }
        }

        return $this;
    }
}
