<?php
namespace App\Controller;

use App\Repository\ConsultAircraftServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConsultAircraftServiceController extends AbstractController
{
    #[Route('/service/consult', name: 'app_consult_service')]
    public function index(ConsultAircraftServiceEntityRepository $repository) {
        $services = $repository->findAll();
        return $this->render('main/consultService.html.twig', [
            'services' => $services,
            'type' => 'service',
        ]);

    }
}