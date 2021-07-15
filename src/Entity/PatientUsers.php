<?php

namespace App\Entity;

use App\Entity\Patient;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientUsersRepository;
use Symfony\Component\Uid\Uuid;

/**
 * This Entity stores Patient list by User.
 * It is updated by message broker when a new Patient has been added
 * 
 * @ORM\Entity(repositoryClass=PatientUsersRepository::class)
 */
class PatientUsers
{

    /**
     * Entity Key for message broker
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private $patientUsersUUID;

    /**
     * Updated by message broker.
     * Points to Patient in remote microservice
     * @ORM\Column(type="uuid")
     */
    private $patientUUID;

    /**
     * Internal relationship between Patients and a User.
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="patient_users")
     * @ORM\JoinColumn(name="user", referencedColumnName="user_uuid", nullable=false)
     */
    private $user;

    public function __construct()
    {
        $this->patientUsersUUID = Uuid::v4();
    }

    public function getPatientUsersUuid()
    {
        return $this->patientUsersUUID;
    }

    public function setPatientUsersUuid($patientUsersUUID): self
    {
        $this->patientUsersUUID = $patientUsersUUID;
        return $this;
    }

    public function getPatientUuid()
    {
        return $this->patientUUID;
    }

    public function setPatientUuid($patientUUID): self
    {
        $this->patientUUID = $patientUUID;
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
}
