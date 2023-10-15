<?php

namespace App\Controller\Admin;


use App\Form\AircraftMaintenanceServiceEditType;
use App\Form\AircraftMaintenanceServiceType;
use App\Form\DocumentEditType;
use App\Form\DocumentFolderEditType;
use App\Form\DocumentFolderType;
use App\Form\DocumentType;
use App\Repository\AircraftMaintenanceServiceEntityRepository;
use App\Repository\DocumentFolderRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security('is_granted("ROLE_ADMIN")')]
class AdminDocumentFolderController extends AbstractController
{

    #[Route('/admin/document_folders', name: 'app_document_folders')]
    public function documents(
        Request                                    $request,
        DocumentFolderRepository $documentRepository,
        EntityManagerInterface                     $entityManager
    ): Response
    {
        $createError = false;
        $editError = false;
        $documentCreateForm = $this->createForm(DocumentFolderType::class);
        $documentCreateForm->handleRequest($request);
        if ($documentCreateForm->isSubmitted()) {
            if ($documentCreateForm->isValid()) {
                $document = $documentCreateForm->getData();
                $entityManager->persist($document);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
            $createError = true;
        }
        $documentEditForm = $this->createForm(DocumentFolderEditType::class);
        $documentEditForm->handleRequest($request);
        if ($documentEditForm->isSubmitted()) {
            if ($documentEditForm->isValid()) {
                $service = $documentRepository->find($documentEditForm->get('id')->getData());
                if ($service) {
                    $service
                        ->setName($documentEditForm->get('name')->getData())
                        ->setIsEnabled($documentEditForm->get('isEnabled')->getData())
                    ;
                }
                $entityManager->persist($service);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
            $editError = true;
        }
        $documents = $documentRepository->findAll();
        return $this->render('admin/documentFolder.html.twig',
            [
                'documentFolderCreateForm' => $documentCreateForm,
                'documentFolderEditForm' => $documentEditForm,
                'documents' => $documents,
                'createError' => $createError,
                'editError' => $editError,
            ]);
    }

    #[Route('/document_folder/delete/{id}', name: 'app_document_folder_delete')]
    public function deleteDocument(
        DocumentFolderRepository $documentRepository,
                           $id,
        EntityManagerInterface                     $entityManager
    ): Response
    {
        $document = $documentRepository->find($id);
        $entityManager->remove($document);
        $entityManager->flush();
        return $this->redirectToRoute("app_document_folders");
    }

}