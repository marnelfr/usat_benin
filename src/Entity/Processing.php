<?php

namespace App\Entity;

use App\Repository\ProcessingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProcessingRepository::class)
 */
class Processing
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $verdict;

    /**
     * @ORM\Column(type="text")
     */
    private $reason;

    /**
     * @ORM\ManyToOne(targetEntity=Transfer::class, inversedBy="processings")
     */
    private $transfer;

    /**
     * @ORM\ManyToOne(targetEntity=Removal::class, inversedBy="processings")
     */
    private $removal;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="processings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVerdict(): ?bool
    {
        return $this->verdict;
    }

    public function setVerdict(?bool $verdict): self
    {
        $this->verdict = $verdict;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(string $reason): self
    {
        $this->reason = $reason;

        return $this;
    }

    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    public function setTransfer(?Transfer $transfer): self
    {
        $this->transfer = $transfer;

        return $this;
    }

    public function getRemoval(): ?Removal
    {
        return $this->removal;
    }

    public function setRemoval(?Removal $removal): self
    {
        $this->removal = $removal;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
