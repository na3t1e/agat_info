<?php
namespace App\Controller;

use App\Repository\FlightServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FlightServiceController extends AbstractController
{
    #[Route('/service/flight', name: 'app_flight_service')]
    public function index(FlightServiceEntityRepository $repository) {
        $services = $repository->findAll();
        return $this->render('main/flightService.html.twig', [
            'services' => $services,
            'type' => 'service',
        ]);

    }
}