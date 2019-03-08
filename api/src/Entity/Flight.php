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
     *
     * @Groups({"flight_write", "flight_read"})
     *
     * @Assert\Length(max="12")
     * @Assert\NotBlank()
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plane", inversedBy="flights")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"flight_write", "flight_read"})
     *
     * @Assert\NotNull()
     */
    private $plane;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ticket", mappedBy="flight", orphanRemoval=true)
     */
    private $tickets;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Crash", inversedBy="flight", cascade={"persist", "remove"})
     */
    private $crash;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights")
     *
     * @Groups({"flight_write", "flight_read"})
     */
    private $arrival;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Airport", inversedBy="flights")
     *
     * @Groups({"flight_write", "flight_read"})
     */
    private $departure;

    public function __construct()
    {
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

    public function getArrival(): ?Airport
    {
        return $this->arrival;
    }

    public function setArrival(?Airport $arrival): self
    {
        $this->arrival = $arrival;

        return $this;
    }

    public function getDeparture(): ?Airport
    {
        return $this->departure;
    }

    public function setDeparture(?Airport $departure): self
    {
        $this->departure = $departure;

        return $this;
    }
}
