<?php

namespace App\Entity;

use App\Repository\RemoverRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=RemoverRepository::class)
 */
class Remover
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le prénom")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner le nom")
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $phone;

    /**
     * @Assert\NotBlank(message="entity.user.email.notblank")
     * @Assert\Email(message="entity.user.email.type")
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Removal::class, mappedBy="remover")
     */
    private $removals;

    /**
     * @ORM\ManyToOne(targetEntity=Agent::class, inversedBy="removers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $agent;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, mappedBy="remover")
     */
    private $vehicles;

    /**
     * @ORM\OneToMany(targetEntity=DemandeFile::class, mappedBy="remover")
     */
    private $demandeFiles;

    public function __construct()
    {
        $this->deleted = 0;
        $this->createdAt = new \DateTime();
        $this->removals = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
        $this->demandeFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    /**
     * @return Collection|Removal[]
     */
    public function getRemovals(): Collection
    {
        return $this->removals;
    }

    public function addRemoval(Removal $removal): self
    {
        if (!$this->removals->contains($removal)) {
            $this->removals[] = $removal;
            $removal->setRemover($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removal): self
    {
        if ($this->removals->contains($removal)) {
            $this->removals->removeElement($removal);
            // set the owning side to null (unless already changed)
            if ($removal->getRemover() === $this) {
                $removal->setRemover(null);
            }
        }

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getFullname() {
        return $this->name . ' ' . $this->lastName;
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

    public function __toString()
    {
        return $this->getFullname();
    }

    /**
     * @return Collection|Vehicle[]
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): self
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles[] = $vehicle;
            $vehicle->setRemover($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getRemover() === $this) {
                $vehicle->setRemover(null);
            }
        }

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
            $demandeFile->setRemover($this);
        }

        return $this;
    }

    public function removeDemandeFile(DemandeFile $demandeFile): self
    {
        if ($this->demandeFiles->contains($demandeFile)) {
            $this->demandeFiles->removeElement($demandeFile);
            // set the owning side to null (unless already changed)
            if ($demandeFile->getRemover() === $this) {
                $demandeFile->setRemover(null);
            }
        }

        return $this;
    }
}
