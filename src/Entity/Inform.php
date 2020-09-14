<?php

namespace App\Entity;

use App\Repository\InformRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InformRepository::class)
 */
class Inform
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
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="informs")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity=DemandeFile::class, mappedBy="inform")
     */
    private $demandeFiles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $resume;

    public function __construct()
    {
        $this->demandeFiles = new ArrayCollection();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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
            $demandeFile->setInform($this);
        }

        return $this;
    }

    public function removeDemandeFile(DemandeFile $demandeFile): self
    {
        if ($this->demandeFiles->contains($demandeFile)) {
            $this->demandeFiles->removeElement($demandeFile);
            // set the owning side to null (unless already changed)
            if ($demandeFile->getInform() === $this) {
                $demandeFile->setInform(null);
            }
        }

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }
}
