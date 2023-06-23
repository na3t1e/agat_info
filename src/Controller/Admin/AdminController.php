<?php

namespace App\Controller\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Security('is_granted("ROLE_ADMIN")')]
class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin_main')]
    public function main(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'АГАТ (Админ - главная)',
            'description' => 'Админка'
        ]);
    }
}
