<?php

namespace App\Controller\Admin;


use App\Form\AircraftFlightServiceEditType;
use App\Form\AircraftFlightServiceType;
use App\Form\AircraftMaintenanceServiceEditType;
use App\Form\AircraftMaintenanceServiceType;
use App\Repository\FlightServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Security('is_granted("ROLE_ADMIN")')]
class AdminFlightServiceController extends AbstractController
{

    #[Route('/admin/aircraft_flight_service', name: 'app_aircraft_flight_service')]
    public function services(
        Request                       $request,
        FlightServiceEntityRepository $serviceRepository,
        EntityManagerInterface        $entityManager
    ): Response
    {
        $createError = false;
        $editError = false;
        $serviceCreateForm = $this->createForm(AircraftFlightServiceType::class);
        $serviceCreateForm->handleRequest($request);
        if ($serviceCreateForm->isSubmitted()) {
            if ($serviceCreateForm->isValid()) {
                $service = $serviceCreateForm->getData();
                $uploadedFile = $serviceCreateForm->get('image')->getData();
                if ($uploadedFile) {
                    $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                    $service->setImage($newFilename);
                }
                $entityManager->persist($service);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
            $createError = true;
        }
        $serviceEditForm = $this->createForm(AircraftFlightServiceEditType::class);
        $serviceEditForm->handleRequest($request);
        if ($serviceEditForm->isSubmitted()) {
            if ($serviceEditForm->isValid()) {
                $service = $serviceRepository->find($serviceEditForm->get('id')->getData());
                if ($service) {
                    $service
                        ->setTitle($serviceEditForm->get('title')->getData())
                        ->setDescription($serviceEditForm->get('description')->getData());
                }
                $uploadedFile = $serviceEditForm->get('image')->getData();
                if ($uploadedFile) {
                    $destination = $this->getParameter('kernel.project_dir') . '/public/uploads';
                    $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                    $newFilename = $originalFilename . '-' . uniqid() . '.' . $uploadedFile->guessExtension();
                    $uploadedFile->move(
                        $destination,
                        $newFilename
                    );
                    $service->setImage($newFilename);
                }
                $entityManager->persist($service);
                $entityManager->flush();
                return $this->redirectToRoute($request->get('_route'), $request->query->all());
            }
            $editError = true;
        }
        $services = $serviceRepository->findAll();
        return $this->render('admin/services/aircraftFlightService.html.twig',
            [
                'serviceCreateForm' => $serviceCreateForm,
                'serviceEditForm' => $serviceEditForm,
                'services' => $services,
                'createError' => $createError,
                'editError' => $editError,
            ]);
    }

    #[Route('/admin/aircraft_flight_service/delete/{id}', name: 'app_aircraft_flight_service_delete')]
    public function deleteService(
        FlightServiceEntityRepository $serviceRepository,
                                      $id,
        EntityManagerInterface        $entityManager
    ): Response
    {
        $service = $serviceRepository->find($id);
        $entityManager->remove($service);
        $entityManager->flush();
        return $this->redirectToRoute("app_aircraft_flight_service");
    }

    #[Route('/admin/pages/aircraft_flight_service/{id}/delete/image/{name}', name: 'app_aircraft_flight_service_delete_image')]
    public function deleteServiceImage(FlightServiceEntityRepository $serviceRepository,
                                                                     $id,
                                       EntityManagerInterface        $entityManager): Response
    {
        $services = $serviceRepository->find($id);
        $image = $services->getImage();
        if ($image != 'caroulsel_void.jpg') {
            $destination = $this->getParameter('kernel.project_dir') . '/public/uploads/';
            unlink($destination . $image);
        }
        $services->setImage(null);
        $entityManager->persist($services);
        $entityManager->flush();

        return $this->redirectToRoute('app_aircraft_flight_service');
    }

}