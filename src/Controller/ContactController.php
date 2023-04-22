<?php

namespace App\Controller;

use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll()[0];

        return $this->render('main/contacts.html.twig', [
            'contacts' => $contacts,
            'controller_name' => 'ContactController',
        ]);
    }


}
