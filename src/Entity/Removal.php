<?php

namespace App\Entity;

use App\Repository\RemovalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RemovalRepository::class)
 */
class Removal
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bfuNum;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $entryNum;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="removals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\OneToOne(targetEntity=Vehicle::class, inversedBy="removal", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    /**
     * @ORM\ManyToOne(targetEntity=Remover::class, inversedBy="removals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $remover;

    /**
     * @ORM\ManyToOne(targetEntity=Bank::class, inversedBy="removals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $payBank;

    /**
     * @ORM\OneToMany(targetEntity=DemandeFile::class, mappedBy="removal")
     */
    private $demandeFiles;

    /**
     * @ORM\OneToMany(targetEntity=Processing::class, mappedBy="removal")
     */
    private $processings;

    public function __construct()
    {
        $this->demandeFiles = new ArrayCollection();
        $this->processings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBfuNum(): ?string
    {
        return $this->bfuNum;
    }

    public function setBfuNum(string $bfuNum): self
    {
        $this->bfuNum = $bfuNum;

        return $this;
    }

    public function getEntryNum(): ?string
    {
        return $this->entryNum;
    }

    public function setEntryNum(string $entryNum): self
    {
        $this->entryNum = $entryNum;

        return $this;
    }

    public function getAgent(): ?Agent
    {
        return $this->agent;
    }

    public function setAgent(?Agent $agent): self
    {
        $this->agent = $agent;

        return $this;
    }

    public function getVehicle(): ?Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): self
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

    public function getPayBank(): ?Bank
    {
        return $this->payBank;
    }

    public function setPayBank(?Bank $payBank): self
    {
        $this->payBank = $payBank;

        return $this;
    }

    /**
     * @return Collection|DemandeFile[]
     */
    public function getDemandeFiles(): Collection
    {
        return $this->demandeFiles;
    }

    public function addDemandeFile(DemandeFile $demandeFile): self
    {
        if (!$this->demandeFiles->contains($demandeFile)) {
            $this->demandeFiles[] = $demandeFile;
            $demandeFile->setRemoval($this);
        }

        return $this;
    }

    public function removeDemandeFile(DemandeFile $demandeFile): self
    {
        if ($this->demandeFiles->contains($demandeFile)) {
            $this->demandeFiles->removeElement($demandeFile);
            // set the owning side to null (unless already changed)
            if ($demandeFile->getRemoval() === $this) {
                $demandeFile->setRemoval(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Processing[]
     */
    public function getProcessings(): Collection
    {
        return $this->processings;
    }

    public function addProcessing(Processing $processing): self
    {
        if (!$this->processings->contains($processing)) {
            $this->processings[] = $processing;
            $processing->setRemoval($this);
        }

        return $this;
    }

    public function removeProcessing(Processing $processing): self
    {
        if ($this->processings->contains($processing)) {
            $this->processings->removeElement($processing);
            // set the owning side to null (unless already changed)
            if ($processing->getRemoval() === $this) {
                $processing->setRemoval(null);
            }
        }

        return $this;
    }
}
