<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;


/*
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields="email", message="Email already taken")
 */

/**
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields="email", message="Un utilisateur existe déjà avec cet adresse email")
 * @UniqueEntity(fields="username", message="Un utilisateur existe déjà avec cet identifiant")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="user_type", type="string")
 * @ORM\DiscriminatorMap({
 *   "User" = "User",
 *   "Agent" = "Agent",
 *   "Manager" = "Manager"
 * })
 */
class User implements UserInterface, \Serializable
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

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
     * @Assert\NotBlank(message="Veuillez renseigner le numéro de téléphone")
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
     * @ORM\Column(type="boolean")
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnection;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Veuillez choisir un profil")
     */
    private $profil;

    /**
     * @ORM\OneToMany(targetEntity=Processing::class, mappedBy="user")
     */
    private $processings;

    /**
     * @ORM\OneToMany(targetEntity=Fleet::class, mappedBy="user")
     */
    private $fleets;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Vehicle::class, mappedBy="user")
     */
    private $vehicles;

    /**
     * @ORM\OneToMany(targetEntity=Importer::class, mappedBy="user")
     */
    private $importers;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="user")
     */
    private $notifications;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="creator")
     */
    private $createdNotifications;

    /**
     * @ORM\OneToMany(targetEntity=Imform::class, mappedBy="user")
     */
    private $imforms;

    /**
     * @ORM\OneToMany(targetEntity=Inform::class, mappedBy="user")
     */
    private $informs;

    /**
     * @ORM\OneToMany(targetEntity=DemandeFile::class, mappedBy="user")
     */
    private $picture;

    /**
     * @ORM\OneToMany(targetEntity=Logger::class, mappedBy="user")
     */
    private $Log;





    public function __construct()
    {
        $this->status= 1;
        $this->createdAt = new \DateTime();
        $this->processings = new ArrayCollection();
        $this->fleets = new ArrayCollection();
        $this->vehicles = new ArrayCollection();
        $this->importers = new ArrayCollection();
        $this->notifications = new ArrayCollection();
        $this->createdNotifications = new ArrayCollection();
        $this->imforms = new ArrayCollection();
        $this->informs = new ArrayCollection();
        $this->picture = new ArrayCollection();
        $this->Log = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = ucwords(strtolower($name));

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = mb_strtoupper($lastName);

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
        if (str_contains((string)$this->email, 'default@dev.fr'))
            return '';
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

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

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

    public function getLastConnection(): ?\DateTimeInterface
    {
        return $this->lastConnection;
    }

    public function setLastConnection(\DateTimeInterface $lastConnection): self
    {
        $this->lastConnection = $lastConnection;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

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
            $processing->setUser($this);
        }

        return $this;
    }

    public function removeProcessing(Processing $processing): self
    {
        if ($this->processings->contains($processing)) {
            $this->processings->removeElement($processing);
            // set the owning side to null (unless already changed)
            if ($processing->getUser() === $this) {
                $processing->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Fleet[]
     */
    public function getFleets(): Collection
    {
        return $this->fleets;
    }

    public function addFleet(Fleet $fleet): self
    {
        if (!$this->fleets->contains($fleet)) {
            $this->fleets[] = $fleet;
            $fleet->setUser($this);
        }

        return $this;
    }

    public function removeFleet(Fleet $fleet): self
    {
        if ($this->fleets->contains($fleet)) {
            $this->fleets->removeElement($fleet);
            // set the owning side to null (unless already changed)
            if ($fleet->getUser() === $this) {
                $fleet->setUser(null);
            }
        }

        return $this;
    }
    
    public function getFullname(): string
    {
        return $this->getName() . ' ' . $this->getLastName();
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }


    public function getIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    /**
     * String representation of object
     * @link http://php.net/manual/en/serializable.serialize.php
     * @return string the string representation of the object or null
     * @since 5.1.0
     */
    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->name,
            $this->lastName,
            $this->password
        ]);
    }

    /**
     * Constructs the object
     * @link http://php.net/manual/en/serializable.unserialize.php
     *
     * @param string $serialized <p>
     * The string representation of the object.
     * </p>
     *
     * @return void
     * @since 5.1.0
     */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->name,
            $this->lastName,
            $this->password
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }

    public function __toString()
    {
        return $this->name . ' ' . $this->lastName;
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
            $vehicle->setUser($this);
        }

        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): self
    {
        if ($this->vehicles->contains($vehicle)) {
            $this->vehicles->removeElement($vehicle);
            // set the owning side to null (unless already changed)
            if ($vehicle->getUser() === $this) {
                $vehicle->setUser(null);
            }
        }

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
            $importer->setUser($this);
        }

        return $this;
    }

    public function removeImporter(Importer $importer): self
    {
        if ($this->importers->contains($importer)) {
            $this->importers->removeElement($importer);
            // set the owning side to null (unless already changed)
            if ($importer->getUser() === $this) {
                $importer->setUser(null);
            }
        }

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
            $notification->setUser($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->contains($notification)) {
            $this->notifications->removeElement($notification);
            // set the owning side to null (unless already changed)
            if ($notification->getUser() === $this) {
                $notification->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getCreatedNotifications(): Collection
    {
        return $this->createdNotifications;
    }

    public function addCreatedNotification(Notification $createdNotification): self
    {
        if (!$this->createdNotifications->contains($createdNotification)) {
            $this->createdNotifications[] = $createdNotification;
            $createdNotification->setCreator($this);
        }

        return $this;
    }

    public function removeCreatedNotification(Notification $createdNotification): self
    {
        if ($this->createdNotifications->contains($createdNotification)) {
            $this->createdNotifications->removeElement($createdNotification);
            // set the owning side to null (unless already changed)
            if ($createdNotification->getCreator() === $this) {
                $createdNotification->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Imform[]
     */
    public function getImforms(): Collection
    {
        return $this->imforms;
    }

    public function addImform(Imform $imform): self
    {
        if (!$this->imforms->contains($imform)) {
            $this->imforms[] = $imform;
            $imform->setUser($this);
        }

        return $this;
    }

    public function removeImform(Imform $imform): self
    {
        if ($this->imforms->contains($imform)) {
            $this->imforms->removeElement($imform);
            // set the owning side to null (unless already changed)
            if ($imform->getUser() === $this) {
                $imform->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Inform[]
     */
    public function getInforms(): Collection
    {
        return $this->informs;
    }

    public function addInform(Inform $inform): self
    {
        if (!$this->informs->contains($inform)) {
            $this->informs[] = $inform;
            $inform->setUser($this);
        }

        return $this;
    }

    public function removeInform(Inform $inform): self
    {
        if ($this->informs->contains($inform)) {
            $this->informs->removeElement($inform);
            // set the owning side to null (unless already changed)
            if ($inform->getUser() === $this) {
                $inform->setUser(null);
            }
        }

        return $this;
    }

    public function getPicture()
    {
        return $this->picture->last();
    }

    public function addPicture(DemandeFile $picture): self
    {
        if (!$this->picture->contains($picture)) {
            $this->picture[] = $picture;
            $picture->setUser($this);
        }

        return $this;
    }

    public function removePicture(DemandeFile $picture): self
    {
        if ($this->picture->contains($picture)) {
            $this->picture->removeElement($picture);
            // set the owning side to null (unless already changed)
            if ($picture->getUser() === $this) {
                $picture->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Logger[]
     */
    public function getLog(): Collection
    {
        return $this->Log;
    }

    public function addLog(Logger $log): self
    {
        if (!$this->Log->contains($log)) {
            $this->Log[] = $log;
            $log->setUser($this);
        }

        return $this;
    }

    public function removeLog(Logger $log): self
    {
        if ($this->Log->contains($log)) {
            $this->Log->removeElement($log);
            // set the owning side to null (unless already changed)
            if ($log->getUser() === $this) {
                $log->setUser(null);
            }
        }

        return $this;
    }
}
