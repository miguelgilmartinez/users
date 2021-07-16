<?php

namespace App\DataFixtures;

use App\Entity\PatientUsers;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Uid\Uuid;
class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('yeah@slsl.com');
        $user->setSagaStatus("NEW");
        $user->setUsername("userzzz");
        $user->setPhoneNumber("+380665555555");
        $patient = new PatientUsers;
        $patient->setUser($user);
        $patient->setPatientUuid(Uuid::v4());
        $user->addPatientUser($patient);
        $manager->persist($user);
        $manager->persist($patient);
        $manager->flush();
    }
}
