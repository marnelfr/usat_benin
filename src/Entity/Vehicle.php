<?php

namespace App\Entity;

use App\Repository\VehicleRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\UniqueConstraint;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
/*  *** @Table(name="vehicle",
 *    uniqueConstraints={
 *        @UniqueConstraint(name="brand_chassis_unique",
 *            columns={"chassis", "brand.name"})
 *    }
 * )*/


/**
 * @ORM\Entity(repositoryClass=VehicleRepository::class)
 * @UniqueEntity(fields={"chassis", "brand"}, message="Un véhicule de même marque existe déjà avec ce numero châssis")
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
     * @ORM\Column(type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Vous devez renseigner un numéro châssis")
     * @Assert\Length(17)
     */
    private $chassis;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual(
     *     value="today",
     *     message="Veuillez renseigner une date valide"
     * )
     */
    private $putInUseAt;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThanOrEqual(
     *     value="today",
     *     message="Veuillez renseigner une date valide"
     * )
     */
    private $cameAt;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le consignataire")
     */
    private $consignee;

    /**
     * @ORM\ManyToOne(targetEntity=Brand::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir une marque")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Ship::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir un navire")
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $bolFileName;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="vehicles")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Remover::class, inversedBy="vehicles")
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

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

    public function setRemoval(?Removal $removal): self
    {
        $this->removal = $removal;

        // set (or unset) the owning side of the relation if necessary
        $newVehicle = null === $removal ? null : $this;
        if ($removal->getVehicle() !== $newVehicle) {
            $removal->setVehicle($newVehicle);
        }

        return $this;
    }

    public function getTransfer(): ?Transfer
    {
        return $this->transfer;
    }

    public function setTransfer(?Transfer $transfer): self
    {
        $this->transfer = $transfer;

        // set (or unset) the owning side of the relation if necessary
        $newVehicle = null === $transfer ? null : $this;
        if ($transfer->getVehicle() !== $newVehicle) {
            $transfer->setVehicle($newVehicle);
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

    public function __toString()
    {
        return $this->getBrand()->getName() . ' - ' . $this->getChassis();
    }

    public function getBolFileName(): ?string
    {
        return $this->bolFileName;
    }

    public function setBolFileName(string $bolFileName): self
    {
        $this->bolFileName = $bolFileName;

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
