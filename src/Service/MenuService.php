<?php

namespace App\Service;

use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class MenuService
{
    private EntityManagerInterface $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    public function getMenu()
    {
        return $this->entityManager->getRepository(Menu::class)->findAll();
    }
}