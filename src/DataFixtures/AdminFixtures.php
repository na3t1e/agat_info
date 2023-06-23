<?php

namespace App\DataFixtures;

use App\Entity\Admin;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AdminFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $admin = new Admin();
        $admin
            ->setUsername('akagat')
            ->setPassword(password_hash('Utyf73445!', PASSWORD_BCRYPT))
            ->setRoles(["ROLE_ADMIN"])
        ;
        $manager->persist($admin);
        $manager->flush();
    }
}
