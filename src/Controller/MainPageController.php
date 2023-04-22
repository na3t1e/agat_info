<?php

namespace App\Controller;

use App\Repository\MainPageRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(MainPageRepository $mainPageRepository): Response
    {
        $mainPage = $mainPageRepository->findAll()[0];

        return $this->render('main/mainPage.html.twig', [
            'mainPage' => $mainPage,
            'controller_name' => 'MainPageController',
        ]);
    }
}
