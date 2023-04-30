<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_main')]
    public function main(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'Каркасыч (Админ - главная)',
            'description' => 'Админка'
        ]);
    }
}
