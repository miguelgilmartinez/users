<?php

namespace App\Entity;

use App\Entity\Patient;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PatientUsersRepository;

/**
 * This Entity stores Patient list by User.
 * It is updated by message broker when a new Patient has been added
 * 
 * @ORM\Entity(repositoryClass=PatientUsersRepository::class)
 */
class PatientUsers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * This same Entity Key for message broker
     * @ORM\Column(type="uuid")
     */
    private $patientUsersUUID;

    /**
     * Updated by message broker.
     * Points to Patient in remote microservice
     * @ORM\Column(type="binary")
     */
    private $patientUUID;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="patientUsers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

     

    public function getId(): ?int
    {
        return $this->id;
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
