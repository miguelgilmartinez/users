<?php

namespace App\Service;

use App\Rabbit\MessageProducer;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This service sends messages to RabbitMQ
 */
class MessageSender
{
    private $messagingProducer;

    public function __construct(MessageProducer $messagingProducer)
    {
        $this->messagingProducer = $messagingProducer;
    }

    /**
     * Sends message to message broker.
     * @param array $emailData
     */
    public function createMessage(array $emailData)
    {
        $message = json_encode([
            'username' => $emailData['username'],
            'email' => $emailData['email'],
            'phonenumber' => $emailData['phonenumber'],
            'uuid' => $emailData['uuid']
        ]);
        $this->messagingProducer->publish($message);
    }
}
