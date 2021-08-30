<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Service\MessageSender;
//use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;


/**
 * Event listener for the User entity.
 */
class UserSubscriber implements EventSubscriber
{
  private $messageService;

  public function __construct(MessageSender $messageSender)
  {
    $this->messageSender = $messageSender;
  }

  public function getSubscribedEvents()
  {
    return [
      Events::postPersist,
    ];
  }

  /**
   * Send AMQP message after user creation.
   *
   * @param LifecycleEventArgs $args
   * @return void
   */
  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();
    if ($entity instanceof User) {
      $this->sendWelcomeMessage($entity);
    }
  }

  /**
   * Compose and send welcome message to AMQP queue.
   *
   * @param User $user
   * @return void
   */
  private function sendWelcomeMessage(User $user)
  {   
    $data = [
      'subject' => "Welcome to GoAndDo, " . $user->getUsername(),
      'from' => 'goanddo@go.com',
      'to' => $user->getEmail(),
      'text' => "Welcome to GoAndDo, " . $user->getUsername() . "!\n\n",
      'html' => "<h1>Welcome to GoAndDo, " . $user->getUsername() . "!</h1>",
      'messageUUID' => uuid_create(\UUID_TYPE_DEFAULT)
    ];

    $result = $this->messageSender->createMessage($data);
  }
}
