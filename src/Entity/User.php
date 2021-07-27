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
     * @ORM\Id()
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

    public function __construct(string $username, string $email, string $phoneNumber = null)
    {
        $this->userUUID = Uuid::v4();
        $this->sagaStatus = 'pending';
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
}
