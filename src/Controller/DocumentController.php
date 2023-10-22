<?php

namespace App\Controller;

use App\Repository\DocumentFolderRepository;
use App\Repository\DocumentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DocumentController extends AbstractController
{
    #[Route('/documents', name: 'app_documents_main')]
    public function index(DocumentFolderRepository $documentFolderRepository,
    DocumentRepository $documentRepository): Response
    {
        $folders = $documentFolderRepository->findBy([
            'isEnabled' => true,
        ]);
        $documents = $documentRepository->findBy([
            'documentFolder' => null
        ]);

        return $this->render('main/documents.html.twig', [
            'folders' => $folders,
            'documents' => $documents,
            'controller_name' => 'ContactController',
        ]);
    }
}