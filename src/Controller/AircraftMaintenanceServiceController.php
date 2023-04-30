<?php
namespace App\Controller;


use App\Repository\AircraftMaintenanceServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AircraftMaintenanceServiceController extends AbstractController
{
    #[Route('/service/maintenance', name: 'app_maintenance_service')]
    public function index(AircraftMaintenanceServiceEntityRepository $repository) {
        $services = $repository->findAll();
        return $this->render('main/maintenanceService.html.twig', [
            'services' => $services,
            'type' => 'service',
        ]);

    }
}