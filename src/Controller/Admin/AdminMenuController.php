<?php

namespace App\Controller\Admin;

use App\Form\ContactType;
use App\Form\MenuType;
use App\Repository\ContactRepository;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminMenuController extends AbstractController
{
    #[Route('/admin/menu', name: 'app_admin_menu')]
    public function menu(Request                $request,
                         EntityManagerInterface $entityManager,
                         MenuRepository         $menuRepository)
    {
        $menuForm = $this->createForm(MenuType::class);
        $menuForm->handleRequest($request);
        if ($menuForm->isSubmitted()) {
            if ($menuForm->isValid()) {
                $menu = $menuRepository->find($menuForm->get('id')->getData());
                $menu->setTitle($menuForm->get('title')->getData())
                    ->setLink($menuForm->get('link')->getData())
                    ->setIsEnabled($menuForm->get('isEnabled')->getData())
                    ;
                $entityManager->persist($menu);
                $entityManager->flush();
            }
        }
        $menu = $menuRepository->findAll();
        return $this->render('admin/menu.html.twig', [
            'controller_name' => 'АГАТ (Админ - Меню)',
            'description' => 'Админка',
            'menuForm' => $menuForm->createView(),
            'menu' => $menu
        ]);
    }
}
