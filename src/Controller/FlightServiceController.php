<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderFlightType;
use App\Form\OrderType;
use App\Handler\TelegramMessageHandler;
use App\Repository\FlightServiceEntityRepository;

use App\Service\TelegramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Notifier\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class FlightServiceController extends AbstractController
{

    /**
     * @throws TransportExceptionInterface
     */
    #[Route('/service/flight', name: 'app_flight_service')]
    public function index(MessageBusInterface $bus, FlightServiceEntityRepository $repository, Request $request)
    {
        $services = $repository->findAll();
        $orderForm = $this->createForm(OrderType::class);
        $orderForm->handleRequest($request);
        $createError = 0;
        if ($orderForm->isSubmitted()) {
            if ($orderForm->isValid()) {
                if ($orderForm->get('name')->getData()) {
                    return $this->redirect('/bot');
                }
                $order = new Order(
                    $orderForm->get('fio')->getData(),
                    $orderForm->get('phone')->getData(),
                    $orderForm->get('email')->getData(),
                    $orderForm->get('serviceType')->getData(),
                    "Услуги по выполнению авиационных работ",
                    $orderForm->get('message')->getData(),
                );
                $bus->dispatch($order);
                $uri = $request->attributes->get("_route");
                return $this->redirectToRoute($uri);
            } else {
                $createError = 1;
            }
        }
        return $this->render('main/flightService.html.twig', [
            'services' => $services,
            'type' => 'service',
            'orderForm' => $orderForm->createView(),
            'createError' => $createError
        ]);

    }
}