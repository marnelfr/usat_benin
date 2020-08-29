<?php

namespace App\Entity;

use App\Repository\DemandeFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DemandeFileRepository::class)
 */
class DemandeFile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Removal::class, inversedBy="demandeFiles")
     */
    private $removal;

    /**
     * @ORM\ManyToOne(targetEntity=Transfer::class, inversedBy="demandeFiles")
     */
    private $transfer;

    /**
     * @ORM\OneToOne(targetEntity=File::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $usedFor;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Vehicle::class, inversedBy="demandeFiles")
     */
    private $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity=Remover::class, inversedBy="demandeFiles")
     */
    private $remover;

    public function __construct()
    {
        $this->deleted = 0;
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    public function setTransfer(?Transfer $transfer): self
    {
        $this->transfer = $transfer;

        return $this;
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getUsedFor(): ?string
    {
        return $this->usedFor;
    }

    public function setUsedFor(string $usedFor): self
    {
        $this->usedFor = $usedFor;

        return $this;
    }

    public function getDeleted(): ?bool
    {
        return $this->deleted;
    }

    public function setDeleted(bool $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(?Vehicle $vehicle): self
    {
        $this->vehicle = $vehicle;

        return $this;
    }

    public function getRemover(): ?Remover
    {
        return $this->remover;
    }

    public function setRemover(?Remover $remover): self
    {
        $this->remover = $remover;

        return $this;
    }
}
