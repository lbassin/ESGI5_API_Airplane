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
 *     denormalizationContext={"groups"={"airport_write"}},
 *     collectionOperations={
 *          "GET"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"
 *          },
 *          "POST"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     },
 *     itemOperations={
 *          "GET"={
 *              "access_control"="is_granted('IS_AUTHENTICATED_ANONYMOUSLY')"
 *          },
 *          "PUT"={
 *              "access_control"="is_granted('ROLE_MANAGER') and is_granted('edit', object)"
 *          },
 *          "DELETE"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     }
 * )
 *
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
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"airport_read", "airport_write"})
     */
    private $manager;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="arrival")
     */
    private $arrivalFlights;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Flight", mappedBy="departure")
     */
    private $departureFlights;


    public function __construct()
    {
        $this->arrivalFlights = new ArrayCollection();
        $this->departureFlights = new ArrayCollection();
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
        $this->code = strtoupper($code);

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

    public function getManager(): ?User
    {
        return $this->manager;
    }

    public function setManager(User $manager): self
    {
        $this->manager = $manager;

        return $this;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getArrivalFlights(): Collection
    {
        return $this->arrivalFlights;
    }

    /**
     * @return Collection|Flight[]
     */
    public function getDepartureFlights(): Collection
    {
        return $this->departureFlights;
    }

}
