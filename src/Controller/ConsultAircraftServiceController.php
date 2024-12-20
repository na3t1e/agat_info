<?php
namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderType;
use App\Repository\ConsultAircraftServiceEntityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ConsultAircraftServiceController extends AbstractController
{
    #[Route('/service/consult', name: 'app_consult_service')]
    public function index(MessageBusInterface $bus, ConsultAircraftServiceEntityRepository $repository, Request $request) {
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
                    "Услуги оценки соответствия воздушных судов, консультации",
                    $orderForm->get('message')->getData(),
                );
                $bus->dispatch($order);
                $uri = $request->attributes->get("_route");
                return $this->redirectToRoute($uri);
            } else {
                $createError = 1;
            }
        }
        return $this->render('main/consultService.html.twig', [
            'services' => $services,
            'orderForm' => $orderForm->createView(),
            'type' => 'service',
            'createError' => $createError
        ]);

    }
}