<?php

namespace App\Entity;

use App\Repository\AgentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AgentRepository::class)
 */
class Agent extends User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

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
     * @ORM\OneToMany(targetEntity=Removal::class, mappedBy="agent")
     */
    private $removals;

    /**
     * @ORM\OneToMany(targetEntity=Remover::class, mappedBy="agent")
     */
    private $removers;

    public function __construct()
    {
        $this->removals = new ArrayCollection();
        $this->removers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $removal->setAgent($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removal): self
    {
        if ($this->removals->contains($removal)) {
            $this->removals->removeElement($removal);
            // set the owning side to null (unless already changed)
            if ($removal->getAgent() === $this) {
                $removal->setAgent(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Remover[]
     */
    public function getRemovers(): Collection
    {
        return $this->removers;
    }

    public function addRemover(Remover $remover): self
    {
        if (!$this->removers->contains($remover)) {
            $this->removers[] = $remover;
            $remover->setAgent($this);
        }

        return $this;
    }

    public function removeRemover(Remover $remover): self
    {
        if ($this->removers->contains($remover)) {
            $this->removers->removeElement($remover);
            // set the owning side to null (unless already changed)
            if ($remover->getAgent() === $this) {
                $remover->setAgent(null);
            }
        }

        return $this;
    }
}
