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
     * @ORM\Column(type="string", length=255)
     */
    private $cinFileName;

    /**
     * @ORM\Column(type="boolean")
     */
    private $deleted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->deleted = 0;
        $this->createdAt = new \DateTime();
        $this->removals = new ArrayCollection();
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

    public function getCinFileName(): ?string
    {
        return $this->cinFileName;
    }

    public function setCinFileName(string $cinFileName): self
    {
        $this->cinFileName = $cinFileName;

        return $this;
    }

    public function __toString()
    {
        return $this->getFullname();
    }
}
