<?php

namespace App\MessageHandler;

use App\Message\NewUserAdded;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class UserAdd implements MessageHandlerInterface
{
    public function __invoke(NewUserAdded $message)
    {
    }
}
