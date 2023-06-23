<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminOrdersController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_main')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'АГАТ (Админ - главная)',
            'description' => 'Админка'
        ]);
    }
}
