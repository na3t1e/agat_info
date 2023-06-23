<?php
namespace App\Controller;


use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\AircraftMaintenanceServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class AircraftMaintenanceServiceController extends AbstractController
{
    #[Route('/service/maintenance', name: 'app_maintenance_service')]
    public function index(MessageBusInterface $bus, AircraftMaintenanceServiceEntityRepository $repository, Request $request) {
        $services = $repository->findAll();
        $orderForm = $this->createForm(OrderType::class);
        $orderForm->handleRequest($request);
        $createError = 0;
        if ($orderForm->isSubmitted()) {
            if ($orderForm->isValid()) {
                $order = new Order(
                    $orderForm->get('fio')->getData(),
                    $orderForm->get('phone')->getData(),
                    $orderForm->get('email')->getData(),
                    $orderForm->get('serviceType')->getData(),
                    "Услуги технического обслуживания судов",
                );
                $bus->dispatch($order);
                $uri = $request->attributes->get("_route");
                return $this->redirectToRoute($uri);
            } else {
                $createError = 1;
            }
        }
        return $this->render('main/maintenanceService.html.twig', [
            'services' => $services,
            'type' => 'service',
            'orderForm' => $orderForm->createView(),
            'createError' => $createError
        ]);

    }
}