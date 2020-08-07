<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ManagerRepository::class)
 */
class Manager extends User
{

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $compagny;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ifu;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $registerNum;

    /**
     * @ORM\ManyToOne(targetEntity=Fleet::class, inversedBy="managers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $fleet;

    /**
     * @ORM\OneToMany(targetEntity=Importer::class, mappedBy="manager")
     */
    private $importers;

    /**
     * @ORM\OneToMany(targetEntity=Transfer::class, mappedBy="manager")
     */
    private $transfers;

    public function __construct()
    {
        parent::__construct();
        $this->importers = new ArrayCollection();
        $this->transfers = new ArrayCollection();
    }

    public function getCompagny(): ?string
    {
        return $this->compagny;
    }

    public function setCompagny(?string $compagny): self
    {
        $this->compagny = $compagny;

        return $this;
    }

    public function getIfu(): ?string
    {
        return $this->ifu;
    }

    public function setIfu(?string $ifu): self
    {
        $this->ifu = $ifu;

        return $this;
    }

    public function getRegisterNum(): ?string
    {
        return $this->registerNum;
    }

    public function setRegisterNum(?string $registerNum): self
    {
        $this->registerNum = $registerNum;

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

    /**
     * @return Collection|Importer[]
     */
    public function getImporters(): Collection
    {
        return $this->importers;
    }

    public function addImporter(Importer $importer): self
    {
        if (!$this->importers->contains($importer)) {
            $this->importers[] = $importer;
            $importer->setManager($this);
        }

        return $this;
    }

    public function removeImporter(Importer $importer): self
    {
        if ($this->importers->contains($importer)) {
            $this->importers->removeElement($importer);
            // set the owning side to null (unless already changed)
            if ($importer->getManager() === $this) {
                $importer->setManager(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transfer[]
     */
    public function getTransfers(): Collection
    {
        return $this->transfers;
    }

    public function addTransfer(Transfer $transfer): self
    {
        if (!$this->transfers->contains($transfer)) {
            $this->transfers[] = $transfer;
            $transfer->setManager($this);
        }

        return $this;
    }

    public function removeTransfer(Transfer $transfer): self
    {
        if ($this->transfers->contains($transfer)) {
            $this->transfers->removeElement($transfer);
            // set the owning side to null (unless already changed)
            if ($transfer->getManager() === $this) {
                $transfer->setManager(null);
            }
        }

        return $this;
    }
}
