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
 *     normalizationContext={"groups"={"plane_read"}}
 * )
 *
 * @ORM\Entity(repositoryClass="App\Repository\PlaneRepository")
 */
class Plane
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=8)
     * @Groups({"plane_read"})
     * @Assert\NotBlank()
     * @Assert\Length(max=8)
     */
    private $registration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Company", inversedBy="planes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"plane_read"})
     */
    private $company;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlaneModel", inversedBy="planes")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"plane_read"})
     */
    private $model;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="plane", orphanRemoval=true)
     */
    private $flights;

    public function __construct()
    {
        $this->flights = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistration(): ?string
    {
        return $this->registration;
    }

    public function setRegistration(string $registration): self
    {
        $this->registration = $registration;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getModel(): ?PlaneModel
    {
        return $this->model;
    }

    public function setModel(?PlaneModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlights(): Collection
    {
        return $this->flights;
    }

    public function addFlight(Flight $flight): self
    {
        if (!$this->flights->contains($flight)) {
            $this->flights[] = $flight;
            $flight->setPlane($this);
        }

        return $this;
    }

    public function removeFlight(Flight $flight): self
    {
        if ($this->flights->contains($flight)) {
            $this->flights->removeElement($flight);
            // set the owning side to null (unless already changed)
            if ($flight->getPlane() === $this) {
                $flight->setPlane(null);
            }
        }

        return $this;
    }
}
