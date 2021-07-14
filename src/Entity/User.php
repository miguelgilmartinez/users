<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="uuid", unique=true)
     */
    private $userUUID;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $phoneNumber;

    /**
     * This field marks entity status inside a saga (MSA transaction)
     * Should be a kind of enum
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $sagaStatus;

    /**
     * @ORM\OneToMany(targetEntity=PatientUsers::class, mappedBy="user", orphanRemoval=true)
     */
    private $patientUsers;

    /**
     * Stores HealthWorker UUID.
     * When this attribute is on, this user is a HealthWorker. 
     * @ORM\Column(type="binary", nullable=true)
     */
    private $healthWorker;

    public function __construct()
    {
        $this->userUUID = Uuid::v4();
        $this->patientUsers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserUuid()
    {
        return $this->userUUID;
    }

    public function setUserUuid($userUUID): self
    {
        $this->userUUID = $userUUID;
        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    public function getSagaStatus(): ?string
    {
        return $this->sagaStatus;
    }

    public function setSagaStatus(?string $sagaStatus): self
    {
        $this->sagaStatus = $sagaStatus;
        return $this;
    }

    /**
     * @return Collection|PatientUsers[]
     */
    public function getPatientUsers(): Collection
    {
        return $this->patientUsers;
    }

    public function addPatientUser(PatientUsers $patientUser): self
    {
        if (!$this->patientUsers->contains($patientUser)) {
            $this->patientUsers[] = $patientUser;
            $patientUser->setUser($this);
        }

        return $this;
    }

    public function removePatientUser(PatientUsers $patientUser): self
    {
        if ($this->patientUsers->removeElement($patientUser)) {
            // set the owning side to null (unless already changed)
            if ($patientUser->getUser() === $this) {
                $patientUser->setUser(null);
            }
        }
        return $this;
    }

    public function getHealthWorker()
    {
        return $this->healthWorker;
    }

    public function setHealthWorker($healthWorker): self
    {
        $this->healthWorker = $healthWorker;
        return $this;
    }
}
