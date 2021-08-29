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
     * @param array $messageData
     */
    public function createMessage(array $messageData)
    {
        $message = json_encode([
            'subject' => $messageData['subject'],
            'from' => $messageData['from'],
            'to' => $messageData['to'],
            'text' => $messageData['text'],
            'html' => $messageData['html'],
        ]);
        $this->messagingProducer->publish($message);
    }
}
