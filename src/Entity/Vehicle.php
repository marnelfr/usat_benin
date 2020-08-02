<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $chassis;

    /**
     * @ORM\Column(type="datetime")
     */
    private $putInUseAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cameAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $consignee;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Ship::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ship;

    /**
     * @ORM\ManyToOne(targetEntity=Importer::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $importer;

    /**
     * @ORM\OneToOne(targetEntity=Removal::class, mappedBy="vehicle", cascade={"persist", "remove"})
     */
    private $removal;

    /**
     * @ORM\OneToOne(targetEntity=Transfer::class, mappedBy="vehicle", cascade={"persist", "remove"})
     */
    private $transfer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChassis(): ?string
    {
        return $this->chassis;
    }

    public function setChassis(string $chassis): self
    {
        $this->chassis = $chassis;

        return $this;
    }

    public function getPutInUseAt(): ?\DateTimeInterface
    {
        return $this->putInUseAt;
    }

    public function setPutInUseAt(\DateTimeInterface $putInUseAt): self
    {
        $this->putInUseAt = $putInUseAt;

        return $this;
    }

    public function getCameAt(): ?\DateTimeInterface
    {
        return $this->cameAt;
    }

    public function setCameAt(\DateTimeInterface $cameAt): self
    {
        $this->cameAt = $cameAt;

        return $this;
    }

    public function getConsignee(): ?string
    {
        return $this->consignee;
    }

    public function setConsignee(string $consignee): self
    {
        $this->consignee = $consignee;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(?Ship $ship): self
    {
        $this->ship = $ship;

        return $this;
    }

    public function getImporter(): ?Importer
    {
        return $this->importer;
    }

    public function setImporter(?Importer $importer): self
    {
        $this->importer = $importer;

        return $this;
    }

    public function getRemoval(): ?Removal
    {
        return $this->removal;
    }

    public function setRemoval(Removal $removal): self
    {
        $this->removal = $removal;

        // set the owning side of the relation if necessary
        if ($removal->getVehicle() !== $this) {
            $removal->setVehicle($this);
        }

        return $this;
    }

    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    public function setTransfer(Transfer $transfer): self
    {
        $this->transfer = $transfer;

        // set the owning side of the relation if necessary
        if ($transfer->getVehicle() !== $this) {
            $transfer->setVehicle($this);
        }

        return $this;
    }
}
