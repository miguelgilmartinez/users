<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="uuid")
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
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=PatientUsers::class, mappedBy="user", orphanRemoval=true)
     */
    private $patientUsers;

    public function __construct()
    {
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $status): self
    {
        $this->state = $status;

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
}
