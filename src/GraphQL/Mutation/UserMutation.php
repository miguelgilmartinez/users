<?php

namespace App\GraphQL\Mutation;

use Overblog\GraphQLBundle\Definition\Resolver\AliasedInterface;
use Overblog\GraphQLBundle\Definition\Resolver\MutationInterface;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @author Miguel Gil Martínez <@miguelgilmartinez@gmail.com>
 * GraphQL resolver for User mutation.
 */
class UserMutation implements MutationInterface, AliasedInterface
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, EntityManagerInterface $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
     * Adding a new user to the system
     *
     * @param string $userName
     * @param string $email
     * @param string $phoneNumber
     * @return array
     */
    public function addUser(string $userName, string $email, string $phoneNumber): User
    {
        $user = new User($userName, $email, $phoneNumber);  // Create a new user
        $this->em->persist($user);
        $this->em->flush();

        /*
        * @todo Check user exists using userRepository or controlling exception
        */
        return $user;
    }

    /**
     * {@inheritdoc}
     */
    public static function getAliases(): array
    {
        return [
            // `add_user` is the name of the mutation that you SHOULD use inside of your types definition
            // `addUser` is the method that will be executed when you call `@=mutation('add_user')`
            'addUser' => 'add_user'
        ];
    }
}
