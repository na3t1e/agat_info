<?php

namespace App\DataFixtures;

use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $contacts = new Contact();

        $contacts
            ->setNumber1("8(999) 888-77-66")
            ->setNumber2('8(777) 654-32-45')
            ->setEmail("agat@yandex.ru")
            ->setArea("г. Санкт-Петербург")
            ->setWorkTime("8:00-22:00")
            ->setAddress("Пушкинская улица, д.2")
        ;
        $manager->persist($contacts);
        $manager->flush();
    }
}
