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
 *     normalizationContext={"groups"={"flight_read"}},
 *     denormalizationContext={"groups"={"flight_write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FlightRepository")
 */
class Flight
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=12)
     * @Groups({"flight_write", "flight_read"})
     * @Assert\Length(max="12")
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)

     */
    private $plane;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Airport", inversedBy="flights_arrival")
     * @ORM\JoinTable(name="flight_airport_arrival")
     */
    private $arrival;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Airport", inversedBy="flights_departure")
     * @ORM\JoinTable(name="flight_airport_departure")
     */
    private $departure;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="flight", orphanRemoval=true)
     */
    private $tickets;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Crash", inversedBy="flight", cascade={"persist", "remove"})
     */
    private $crash;

    public function __construct()
    {
        $this->arrival = new ArrayCollection();
        $this->departure = new ArrayCollection();
        $this->tickets = new ArrayCollection();
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

    public function getPlane(): ?Plane
    {
        return $this->plane;
    }

    public function setPlane(?Plane $plane): self
    {
        $this->plane = $plane;

        return $this;
    }

    /**
     * @return Collection|Airport[]
     */
    public function getArrival(): Collection
    {
        return $this->arrival;
    }

    public function addArrival(Airport $arrival): self
    {
        if (!$this->arrival->contains($arrival)) {
            $this->arrival[] = $arrival;
        }

        return $this;
    }

    public function removeArrival(Airport $arrival): self
    {
        if ($this->arrival->contains($arrival)) {
            $this->arrival->removeElement($arrival);
        }

        return $this;
    }

    /**
     * @return Collection|Airport[]
     */
    public function getDeparture(): Collection
    {
        return $this->departure;
    }

    public function addDeparture(Airport $departure): self
    {
        if (!$this->departure->contains($departure)) {
            $this->departure[] = $departure;
        }

        return $this;
    }

    public function removeDeparture(Airport $departure): self
    {
        if ($this->departure->contains($departure)) {
            $this->departure->removeElement($departure);
        }

        return $this;
    }

    /**
     * @return Collection|Ticket[]
     */
    public function getTickets(): Collection
    {
        return $this->tickets;
    }

    public function addTicket(Ticket $ticket): self
    {
        if (!$this->tickets->contains($ticket)) {
            $this->tickets[] = $ticket;
            $ticket->setFlight($this);
        }

        return $this;
    }

    public function removeTicket(Ticket $ticket): self
    {
        if ($this->tickets->contains($ticket)) {
            $this->tickets->removeElement($ticket);
            // set the owning side to null (unless already changed)
            if ($ticket->getFlight() === $this) {
                $ticket->setFlight(null);
            }
        }

        return $this;
    }

    public function getCrash(): ?Crash
    {
        return $this->crash;
    }

    public function setCrash(?Crash $crash): self
    {
        $this->crash = $crash;

        return $this;
    }
}
