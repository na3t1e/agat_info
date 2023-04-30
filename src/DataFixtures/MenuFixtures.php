<?php

namespace App\DataFixtures;

use App\Entity\Menu;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MenuFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $menu = new Menu();
        $menu->setTitle("Главная")->setLink('/')->setIsEnabled(true);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setTitle("Услуги")->setLink('/service/flight')->setIsEnabled(true);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setTitle("Отзывы")->setLink('/reviews')->setIsEnabled(true);
        $manager->persist($menu);

        $menu = new Menu();
        $menu->setTitle("Контакты")->setLink('/contacts')->setIsEnabled(true);
        $manager->persist($menu);


        $manager->flush();

    }
}