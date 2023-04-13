<?php

namespace App\Controller\Admin;

use App\Form\MainPageType;
use App\Repository\MainPageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class AdminMainPageController extends AbstractController{
    #[Route('/admin/pages/mainPage', name: 'app_admin_pages_main_page')]
    public function mainPage(Request                $request,
                             MainPageRepository     $mainPageRepository,
                             EntityManagerInterface $entityManager): Response
    {
        $mainPage = $mainPageRepository->findAll()[0];
        $mainPageForm = $this->createForm(MainPageType::class, $mainPage);
        $mainPageForm->handleRequest($request);
        if ($mainPageForm->isSubmitted() && $mainPageForm->isValid()) {
            $mainPage = $mainPageForm->getData();
            $images = $mainPageForm->get('images')->getData();
            foreach ($images as $image) {
                $uploadedFile = $image;
                $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                $uploadedFile->move(
                    $destination,
                    $newFilename
                );
                $mainPage->addImage($newFilename);
            }
            $entityManager->persist($mainPage);
            $entityManager->flush();
            return $this->redirectToRoute($request->get('_route'), $request->query->all());
        }
        return $this->render('admin/mainPage.html.twig', [
            'controller_name' => 'Каркасыч (Админ - Страницы - Главная)',
            'description' => 'Админка',
            'mainPage' => $mainPage,
            'mainPageForm' => $mainPageForm->createView(),
        ]);
    }

    #[Route('/admin/pages/mainPage/delete/image/{name}', name: 'app_admin_pages_main_page_delete_image')]
    public function deleteMainPageImage(
        $name,
        MainPageRepository $mainPageRepository,
        EntityManagerInterface $entityManager): Response
    {
        $mainPage = $mainPageRepository->findAll()[0];
        $images = $mainPage->getImages();
        if (($key = array_search($name, $images)) !== false) {
            unset($images[$key]);
        }
        if ($name != 'caroulsel_void.jpg') {
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            unlink($destination . $name);
        }
        $mainPage->setImages($images);
        $entityManager->persist($mainPage);
        $entityManager->flush();

        return $this->redirectToRoute('app_admin_pages_main_page');
    }

}
