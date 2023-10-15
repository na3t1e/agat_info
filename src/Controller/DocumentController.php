<?php

namespace App\Controller;

use App\Repository\DocumentFolderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    #[Route('/documents', name: 'app_documents_main')]
    public function index(DocumentFolderRepository $documentFolderRepository): Response
    {
        $folders = $documentFolderRepository->findBy([
            'isEnabled' => true,
        ]);

        return $this->render('main/documents.html.twig', [
            'folders' => $folders,
            'controller_name' => 'ContactController',
        ]);
    }
}