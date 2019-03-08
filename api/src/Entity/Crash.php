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
 *     normalizationContext={"groups"={"crash_read"}},
 *     denormalizationContext={"groups"={"crash_write"}},
 *     collectionOperations={
 *          "GET"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          },
 *          "POST"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     },
 *     itemOperations={
 *          "GET"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          },
 *          "PUT"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          },
 *          "DELETE"={
 *              "access_control"="is_granted('ROLE_ADMIN')"
 *          }
 *     }
 * )
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
     *
     * @Groups({"crash_write", "crash_read"})
     *
     * @Assert\LessThan(value="today")
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @ORM\Column(type="boolean")
     *
     * @Groups({"crash_write", "crash_read"})
     */
    private $found;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Flight", mappedBy="crash", cascade={"persist", "remove"})
     *
     * @Groups({"crash_write", "crash_read"})
     *
     * @Assert\NotBlank()
     */
    private $flight;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dead", mappedBy="crash", orphanRemoval=true)
     */
    private $deads;

    public function __construct()
    {
        $this->deads = new ArrayCollection();
    }

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

    /**
     * @return Collection|Dead[]
     */
    public function getDeads(): Collection
    {
        return $this->deads;
    }

    public function addDead(Dead $dead): self
    {
        if (!$this->deads->contains($dead)) {
            $this->deads[] = $dead;
            $dead->setCrash($this);
        }

        return $this;
    }

    public function removeDead(Dead $dead): self
    {
        if ($this->deads->contains($dead)) {
            $this->deads->removeElement($dead);
            // set the owning side to null (unless already changed)
            if ($dead->getCrash() === $this) {
                $dead->setCrash(null);
            }
        }

        return $this;
    }
}
