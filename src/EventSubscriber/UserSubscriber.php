<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Service\MessageSender;
//use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Events;

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

  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();
    if ($entity instanceof User) {
      // dump ($args); die();
      // -userUUID: Symfony\Component\Uid\UuidV4 {#894
      //   #uid: "556e8f44-ec7d-4fd2-b99c-be9e586b0bf6"
      // }
      // -username: "2x3meefgva33ws3os3"
      // -email: "man233elodwe@smanwfs3o.com"
      // -phoneNumber: "98s776"
      // -sagaStatus: "pending"
      $user = $args->getObject();
      $data = [
        'username' => $user->getUsername(),
        'email' => $user->getEmail(),
        'phonenumber' => $user->getPhoneNumber(),
        'uuid' => $user->getUserUuid(),
      ];

      $this->messageSender->createMessage($data);
    }
  }
}
