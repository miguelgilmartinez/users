<?php

namespace App\DataFixtures;

use App\Entity\PatientUsers;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;

/**
 * @author Miguel Gil Martínez <@miguelgilmartinez@gmail.com>
 * User fixtures. This is a sample data fixture for testing purposes.
 */
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User("userXXXX", "test@test.com", "+34 950456191");
        $user->setSagaStatus("NEW");
        $manager->persist($user);
        $manager->flush();
    }
}
