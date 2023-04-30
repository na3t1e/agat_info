<?php

namespace App\Controller\Admin;

use App\Form\FeedbackEditType;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminFeedbackController extends AbstractController
{
    #[Route('/admin/feedbacks', name: 'app_admin_feedbacks')]
    public function getFeedback(FeedbackRepository     $feedbackRepository,
                                Request                $request,
                                EntityManagerInterface $entityManager): Response
    {
        $newFeedbacks = $feedbackRepository->findBy([
            "status" => "notChecked"
        ]);
        $activeFeedbacks = $feedbackRepository->findBy([
            "status" => "active"
        ]);
        $archivedFeedbacks = $feedbackRepository->findBy([
            "status" => "archived"
        ]);
        $feedbackEditForm = $this->createForm(FeedbackEditType::class);
        $feedbackEditForm->handleRequest($request);
        if ($feedbackEditForm->isSubmitted()) {
            if ($feedbackEditForm->isValid()) {
                $feedback = $feedbackRepository->find($feedbackEditForm->get('id')->getData());
                if ($feedback) {
                    $createAt = $feedbackEditForm->get('createAt')->getData();
                    $feedback->setText($feedbackEditForm->get('text')->getData())
                        ->setName($feedbackEditForm->get('name')->getData())
                        ->setCreateAt($createAt)
                        ->setRating($feedbackEditForm->get('rating')->getData());
                    if ($feedbackEditForm->get('images')->getData()) {
                        $images = $feedbackEditForm->get('images')->getData();
                        foreach ($images as $image) {
                            $uploadedFile = $image;
                            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                            $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                            $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                            $uploadedFile->move(
                                $destination,
                                $newFilename
                            );
                            $feedback->addImage($newFilename);
                        }
                    }
                    $entityManager->persist($feedback);
                    $entityManager->flush();
                    return $this->redirectToRoute("app_admin_feedbacks");
                }
            }
        }
        return $this->render('admin/feedback.html.twig', [
            'controller_name' => 'AdminFeedbackController',
            'newFeedbacks' => $newFeedbacks,
            'activeFeedbacks' => $activeFeedbacks,
            'archivedFeedbacks' => $archivedFeedbacks,
            'feedbackEditForm' => $feedbackEditForm->createView()
        ]);
    }

    #[Route('/admin/feedbacks/activate/{id}', name: 'app_admin_feedback_activate')]
    public function activeFeedback(FeedbackRepository     $feedbackRepository,
                                                          $id,
                                   EntityManagerInterface $entityManager): Response
    {
        $feedback = $feedbackRepository->find($id);
        $feedback->setStatus("active");
        $entityManager->persist($feedback);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin_feedbacks");
    }

    #[Route('/admin/feedbacks/archive/{id}', name: 'app_admin_feedback_archive')]
    public function archiveFeedback(FeedbackRepository     $feedbackRepository,
                                                           $id,
                                    EntityManagerInterface $entityManager): Response
    {
        $feedback = $feedbackRepository->find($id);
        $feedback->setStatus("archived");
        $entityManager->persist($feedback);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin_feedbacks");
    }

    #[Route('/admin/feedbacks/delete/{id}', name: 'app_admin_feedback_delete')]
    public function deleteReview(FeedbackRepository     $feedbackRepository,
                                                        $id,
                                 EntityManagerInterface $entityManager): Response
    {
        $feedback = $feedbackRepository->find($id);
        $entityManager->remove($feedback);
        $entityManager->flush();
        return $this->redirectToRoute("app_admin_feedbacks");
    }

    #[Route('/admin/pages/feedbacks/{id}/delete/image/{name}', name: 'app_admin_pages_feedback_delete_image')]
    public function deleteFeedbackImage(FeedbackRepository     $feedbackRepository,
                                        EntityManagerInterface $entityManager,
                                                               $id,
                                                               $name): Response
    {
        $feedback = $feedbackRepository->find($id);
        $images = $feedback->getImages();
        if (($key = array_search($name, $images)) !== false) {
            unset($images[$key]);
        }
        if ($name != 'caroulsel_void.jpg') {
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            unlink($destination . $name);
        }
        $feedback->setImages($images);
        $entityManager->persist($feedback);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin_feedbacks');
    }
}
