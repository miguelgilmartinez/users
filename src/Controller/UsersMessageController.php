<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Service\MessageSender;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

/**
 * @author Miguel Gil Martínez <@miguelgilmartinez@gmail.com>
 */
class UsersMessageController
{
    private $messageService;
    private $clonado;

    public function __construct()
    {
        $this->clonado = clone ($this);
        $this->clonado->setMessageService();
    }

    public function setMessageService(MessageSender $messageService)
    {
        $this->messageService = $messageService;
    }

    public function send(array $data): void
    {
        $this->setMessageService();
        $this->messageService->createMessage($data);
    }
}
