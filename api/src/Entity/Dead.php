<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     normalizationContext={"groups"={"dead_read"}},
 *     denormalizationContext={"groups"={"dead_write"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\DeadRepository")
 */
class Dead
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Crash", inversedBy="deads")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Groups({"dead_write", "dead_read"})
     *
     * @Assert\NotNull()
     */
    private $crash;

    public function getId(): ?int
    {
        return $this->id;
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
