<?php

namespace App\Entity;

use App\Repository\TransferRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransferRepository::class)
 */
class Transfer
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
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Manager::class, inversedBy="transfers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $manager;

    /**
     * @ORM\OneToMany(targetEntity=DemandeFile::class, mappedBy="transfer")
     */
    private $demandeFiles;

    /**
     * @ORM\OneToMany(targetEntity=Processing::class, mappedBy="transfer")
     */
    private $processings;

    /**
     * @ORM\OneToOne(targetEntity=Vehicle::class, inversedBy="transfer", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $vehicle;

    public function __construct()
    {
        $this->status = 'waiting';
        $this->deleted = 0;
        $this->createdAt = new \DateTime();
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

    public function getState(): ?string
    {
        switch ($this->status) {
            case 'waiting':
                $etat = 'En attente';
                break;
            case 'inprogress':
                $etat = 'En cours';
                break;
            case 'canceled':
                $etat = 'Annulée';
                break;
            case 'finalized':
                $etat = $this->getProcessing()->getUser() ? 'Approuvée par <br>' . $this->getProcessing()->getUser()->getFullname() : 'Approuvée';
                break;
            case 'approved':
                $etat = $this->getProcessing()->getUser() ? 'Approuvée par <br>' . $this->getProcessing()->getUser()->getFullname() : 'Approuvée';
                break;
            default:
                $etat = 'Rejetée';
        }
        return $etat;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

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

    public function getManager(): ?Manager
    {
        return $this->manager;
    }

    public function setManager(?Manager $manager): self
    {
        $this->manager = $manager;

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
            $demandeFile->setTransfer($this);
        }

        return $this;
    }

    public function removeDemandeFile(DemandeFile $demandeFile): self
    {
        if ($this->demandeFiles->contains($demandeFile)) {
            $this->demandeFiles->removeElement($demandeFile);
            // set the owning side to null (unless already changed)
            if ($demandeFile->getTransfer() === $this) {
                $demandeFile->setTransfer(null);
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

    /**
     * @return bool|Processing
     */
    public function getProcessing()
    {
        return $this->processings->last();
    }

    public function addProcessing(Processing $processing): self
    {
        if (!$this->processings->contains($processing)) {
            $this->processings[] = $processing;
            $processing->setTransfer($this);
        }

        return $this;
    }

    public function removeProcessing(Processing $processing): self
    {
        if ($this->processings->contains($processing)) {
            $this->processings->removeElement($processing);
            // set the owning side to null (unless already changed)
            if ($processing->getTransfer() === $this) {
                $processing->setTransfer(null);
            }
        }

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
}
