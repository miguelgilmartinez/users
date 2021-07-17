<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersMessageController extends AbstractController
{
    /**
     * @Route("/users/message", name="users_message")
     */
    public function index(): Response
    {
        return $this->render('users_message/index.html.twig', [
            'controller_name' => 'UsersMessageController',
        ]);
    }
}
