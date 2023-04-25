<?php

namespace App\DataFixtures;


use App\Entity\Feedback;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FeedbackFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $feedbacks = new Feedback();

        $feedbacks
            ->setName("Иванова Анастасия")
            ->setText("Все безумно  поравилось")
            ->setRating(5)
            ->setStatus("notChecked")
            ->setCreateAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow')))
            ->setImages(['caroulsel_void.jpg']);
        $manager->persist($feedbacks);
        $manager->flush();
    }
}

