<?php

namespace App\Entity;

use App\Repository\RemovalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RemovalRepository::class)
 * @UniqueEntity(fields={"bfuNum", "payBank"}, message="Un payement a déjà été enregistré avec ce numéro")
 * @UniqueEntity(fields={"entryNum"}, message="Une déclaration en Douane a déjà été fait avec ce numéro")
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
     * @ORM\Column(type="string", length=255, unique=true)
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="removal")
     */
    private $notifications;

    /**
     * @ORM\ManyToOne(targetEntity=Fleet::class, inversedBy="removals")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fleet;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $reference;

    public function __construct()
    {
        $this->deleted = 0;
        $this->createdAt = new \DateTime();
        $this->demandeFiles = new ArrayCollection();
        $this->processings = new ArrayCollection();
        $this->notifications = new ArrayCollection();
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

    /**
     * @param string $use
     *
     * @return File
     */
    public function getDemandeFile(string $use): ?File
    {
        foreach ($this->demandeFiles as $demandeFile) {
            if ($demandeFile->getUsedFor() === $use) {
                return $demandeFile->getFile();
            }
        }
        return null;
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

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setRemoval($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getRemoval() === $this) {
                $notification->setRemoval(null);
            }
        }

        return $this;
    }

    public function getFleet(): ?Fleet
    {
        return $this->fleet;
    }

    public function setFleet(?Fleet $fleet): self
    {
        $this->fleet = $fleet;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }
}
