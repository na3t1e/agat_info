<?php

namespace App\Controller;

use App\Form\FeedbackType;
use App\Form\FeedbackWriteType;
use App\Repository\FeedbackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FeedbackController extends AbstractController
{
      #[Route('/feedbacks', name: 'app_feedbacks')]
    public function getFeedbacks(Request                $request,
                                 EntityManagerInterface $entityManager,
                                 FeedbackRepository     $feedbackRepository)
    {


        $feedbackForm = $this->createForm(FeedbackWriteType::class);
        $feedbackForm->handleRequest($request);
        if ($feedbackForm->isSubmitted()) {
            if ($feedbackForm->isValid()) {
                $feedback = $feedbackForm->getData();
                $entityManager->persist($feedback);
                $entityManager->flush();
                return $this->redirect($request->getUri());
            }
        }
        $feedbackCreateForm = $this->createForm(FeedbackType::class);
        $feedbackCreateForm->handleRequest($request);
        if ($feedbackCreateForm->isSubmitted()) {
            if ($feedbackCreateForm->isValid()) {
                $feedback = $feedbackCreateForm->getData();
                $images = $feedbackCreateForm->get('images')->getData();
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
                $feedback->setStatus('notChecked');
                $feedback->setCreateAt(new \DateTimeImmutable('now', new \DateTimeZone('Europe/Moscow')));
                $entityManager->persist($feedback);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
        }
        return $this->render('main/feedback.html.twig',
            [
                'controller_name' => 'FeedbackController',
                'feedbacks' => $feedbackRepository->findBy(['status' => 'published']),
                'feedbackForm' => $feedbackForm->createView(),
                'feedbackCreateForm' => $feedbackCreateForm->createView(),
            ]);
    }

    #[Route('/feedbacks/{id}', name: 'app_feedback')]
    public function getFeedback(FeedbackRepository $feedbackRepository,
                                                   $id)
    {
        return $this->render('particles/modal_feedback_caroulsel.html.twig', [
        ]);
    }
}
