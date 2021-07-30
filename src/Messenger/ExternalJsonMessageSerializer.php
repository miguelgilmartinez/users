<?php

namespace App\Messenger;

use App\Message\Command\LogEmoji;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use App\Entity\User;

class ExternalJsonMessageSerializer implements SerializerInterface
{
    /**
     * Decodes a message from message broker.
     * This could be a good starting point for a custom message serializer.
     * @var array $encodedEnvelope
     * @return Envelope 
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];
        $data = json_decode($body, true);
        $message = new User($data['username'], $data['email'], $data['phonenumber']);
        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }
        // Probable we should return a User object, or a Command operation to add, remove, or update a user
        return new Envelope($message, $stamps);
    }

    /**
     * This method convers a User entity into a message that can be sent to the message broker.
     * @var Envelope $envelope
     * @return array with keys 'body' and 'headers'
     */
    public function encode(Envelope $envelope): array
    {
        // this is called if a message is redelivered for "retry"
        $message = $envelope->getMessage();
        // expand this logic later if you handle more than
        // just one message class
        if ($message instanceof User) {
            // recreate what the data originally looked like
            $data = [
                'username' => $message->getUsername(),
                'email' => $message->getEmail(),
                'phonenumber' => $message->getPhonenumber(),
                'uuid' => $message->getUserUUID()
            ];
        } else {
            throw new \Exception('Unsupported message class. Not an USER');
        }

        $allStamps = [];
        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }

        return [
            'body' => json_encode($data),
            'headers' => [
                // store stamps as a header - to be read in decode()
                'stamps' => serialize($allStamps)
            ],
        ];
    }
}
