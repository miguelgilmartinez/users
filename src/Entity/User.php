<?php

namespace App\Entity;

// use App\Repository\UserRepository;
// use Doctrine\Common\Collections\ArrayCollection;
// use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Doctrine\ORM\Event\LifecycleEventArgs;
use App\Message\NewUserAdded;
// use Symfony\Component\Messenger\Envelope;
// use Symfony\Component\Messenger\MessageBusInterface;
/**
 * @author Miguel Gil Martínez <@miguelgilmartinez@gmail.com>
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\Column(type="uuid", unique=true)
     */
    private $userUUID;

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
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
        $this->username = $username;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
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
     * Listener triggered after user is persisted when initial creation.
     * Let's notify back.
     * @ORM\PostPersist
     * @param LifecycleEventArgs $event Event data, usuarlly the entity
     */
    public function postPersistUser(LifecycleEventArgs $event): void
    {
        // Now we can notify back to the message broker
        $this->notifyBackNewUser();
    }
    /**
     * @ORM\PrePersist
     * Listener triggered before persisting on initial User creation.
     * @param LifecycleEventArgs $event Event data, usually the entity
     */
    public function prePersistUser(LifecycleEventArgs $event): void
    {
        // Put here your logic to run before persisting the entity
    }

    /**
     * @ORM\PreUpdate
     * @param LifecycleEventArgs $event Event data, usually the entity
     * Listener triggered before persisting User when modifying.
     */
    public function preUpdateUser(LifecycleEventArgs $event): void
    {
        // Put here logic to run before persisting
    }

    /**
     * @ORM\PostUpdate
     * @param LifecycleEventArgs $event Datos del evento, generalmente la entidad
     * Listener triggered after updating User.
     */
    public function postUpdateUser(LifecycleEventArgs $event): void
    {
        // Put here logic to run after updating User    
    }
    /**
     * @ORM\PostRemove
     * @param LifecycleEventArgs $event Event data, usually the entity
     * Listener triggered after eliminating a User.
     */
    public function postRemoveUser(LifecycleEventArgs $event): void
    {
        // Put here logic to run after eliminating a User
    }

    /**
     * @ORM\PreRemove
     * @param LifecycleEventArgs $event Event data, usually the entity
     * Listener triggered before eliminating a User.
     */
    public function preRemoveUser(LifecycleEventArgs $event): void
    {
    }

    /**
     * 
     */
    private function notifyBackNewUser(): void
    {
        $message = new NewUserAdded($this);
       // $message = new NewUserAdded();
    }
}
