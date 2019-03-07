<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"airport_read"}},
 *     denormalizationContext={"groups"={"airport_write"}}
 * )
 * @ORM\Entity(repositoryClass="App\Repository\AirportRepository")
 *
 * @UniqueEntity("code")
 */
class Airport
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=3)
     *
     * @Groups({"airport_read", "airport_write"})
     *
     * @Assert\Length(min="3", max="3")
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"airport_read", "airport_write"})
     *
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"airport_read", "airport_write"})
     *
     * @Assert\Length(max="255")
     * @Assert\NotBlank()
     */
    private $address;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", mappedBy="arrival")
     */
    private $flights_arrival;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Flight", mappedBy="departure")
     */
    private $flights_departure;

    public function __construct()
    {
        $this->flights_arrival = new ArrayCollection();
        $this->flights_departure = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlightsArrival(): Collection
    {
        return $this->flights_arrival;
    }

    public function addFlightArrival(Flight $flight): self
    {
        if (!$this->flights_arrival->contains($flight)) {
            $this->flights_arrival[] = $flight;
            $flight->addArrival($this);
        }

        return $this;
    }

    public function removeFlightArrival(Flight $flight): self
    {
        if ($this->flights_arrival->contains($flight)) {
            $this->flights_arrival->removeElement($flight);
            $flight->removeArrival($this);
        }

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getFlightsDeparture(): Collection
    {
        return $this->flights_departure;
    }

    public function addFlightsDeparture(Flight $flightsDeparture): self
    {
        if (!$this->flights_departure->contains($flightsDeparture)) {
            $this->flights_departure[] = $flightsDeparture;
            $flightsDeparture->addDeparture($this);
        }

        return $this;
    }

    public function removeFlightsDeparture(Flight $flightsDeparture): self
    {
        if ($this->flights_departure->contains($flightsDeparture)) {
            $this->flights_departure->removeElement($flightsDeparture);
            $flightsDeparture->removeDeparture($this);
        }

        return $this;
    }
}
