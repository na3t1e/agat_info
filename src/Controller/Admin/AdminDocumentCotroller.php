<?php

namespace App\Controller\Admin;


use App\Form\AircraftMaintenanceServiceEditType;
use App\Form\AircraftMaintenanceServiceType;
use App\Form\DocumentEditType;
use App\Form\DocumentType;
use App\Repository\AircraftMaintenanceServiceEntityRepository;
use App\Repository\DocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security('is_granted("ROLE_ADMIN")')]
class AdminDocumentCotroller extends AbstractController
{

    #[Route('/admin/documents', name: 'app_admin_documents')]
    public function documents(
        Request                                    $request,
        DocumentRepository $documentRepository,
        EntityManagerInterface                     $entityManager
    ): Response
    {
        $createError = false;
        $editError = false;
        $documentCreateForm = $this->createForm(DocumentType::class);
        $documentCreateForm->handleRequest($request);
        if ($documentCreateForm->isSubmitted()) {
            if ($documentCreateForm->isValid()) {
                $document = $documentCreateForm->getData();
                $uploadedFile = $documentCreateForm->get('filename')->getData();
                if ($uploadedFile) {
                    $destination = $this->getParameter('kernel.project_dir') . '/public/files';
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                    $document->setFilename($newFilename);
                }
                $entityManager->persist($document);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
            $createError = true;
        }
        $documentEditForm = $this->createForm(DocumentEditType::class);
        $documentEditForm->handleRequest($request);
        if ($documentEditForm->isSubmitted()) {
            if ($documentEditForm->isValid()) {
                $service = $documentRepository->find($documentEditForm->get('id')->getData());
                if ($service) {
                    $service
                        ->setTitle($documentEditForm->get('title')->getData())
                        ->setDescription($documentEditForm->get('description')->getData());
                }
                $uploadedFile = $documentEditForm->get('filename')->getData();
                if ($uploadedFile) {
                    $destination = $this->getParameter('kernel.project_dir') . '/public/files';
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                    $service->setFilename($newFilename);
                }
                $entityManager->persist($service);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
            $editError = true;
        }
        $documents = $documentRepository->findAll();
        return $this->render('admin/document.html.twig',
            [
                'documentCreateForm' => $documentCreateForm,
                'documentEditForm' => $documentEditForm,
                'documents' => $documents,
                'createError' => $createError,
                'editError' => $editError,
            ]);
    }

    #[Route('/admin/document/delete/{id}', name: 'app_document_delete')]
    public function deleteDocument(
        DocumentRepository $documentRepository,
                                                   $id,
        EntityManagerInterface                     $entityManager
    ): Response
    {
        $document = $documentRepository->find($id);
        $entityManager->remove($document);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin_documents");
    }


}