<?php
namespace App\Message;
use Symfony\Component\Messenger\MessageBusInterface;
use App\Entity\User;
/**
 * @author Miguel Gil Martínez <@miguelgilmartinez@gmail.com>
 * This class defines the message sent when a new user is added to system.
 */
class NewUserAdded
{
    private $busInterface;
    /**
     * 
     */
    public function __construct(MessageBusInterface $bus)
    {
        $this->busInterface = $bus;
    }

    /**
     * 
     */
    public function send(
        string $username,
        string $email,
        string $phonenumber,
        string $userUUID
    ) {
        $user = new User($username, $email, $phonenumber, $userUUID);
        $this->busInterface->dispatch($user);
    }
}
