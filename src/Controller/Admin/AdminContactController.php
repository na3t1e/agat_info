<?php

namespace App\Controller\Admin;

use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Security('is_granted("ROLE_ADMIN")')]
class AdminContactController extends AbstractController
{
    #[Route('/admin/contacts', name: 'app_admin_contacts')]
    public function index(ContactRepository $contactRepository,
                          Request           $request,
                          EntityManagerInterface $entityManager): Response
    {
        $contacts = $contactRepository->findAll()[0];
        $contactEditForm = $this->createForm(ContactType::class, $contacts);
        $contactEditForm->handleRequest($request);
        if($contactEditForm->isSubmitted()){
            if($contactEditForm->isValid()){
                $contact = $contactEditForm->getData();
                $entityManager ->persist($contact);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
        }
        return $this->render('admin/contact.html.twig', [
            'contactEditForm'=>$contactEditForm,
            'controller_name' => 'AdminContactController',
            'contacts' => $contacts
        ]);
    }


}
