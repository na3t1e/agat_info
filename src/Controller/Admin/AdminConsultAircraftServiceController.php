<?php

namespace App\Controller\Admin;


use App\Form\AircraftConsultServiceEditType;
use App\Form\AircraftConsultServiceType;
use App\Form\AircraftMaintenanceServiceEditType;
use App\Form\AircraftMaintenanceServiceType;
use App\Repository\ConsultAircraftServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//#[Security('is_granted("ROLE_ADMIN")')]
class AdminConsultAircraftServiceController extends AbstractController
{

    #[Route('/admin/aircraft_consult_service', name: 'app_aircraft_consult_service')]
    public function services(
        Request                                    $request,
        ConsultAircraftServiceEntityRepository $serviceRepository,
        EntityManagerInterface                     $entityManager
    ): Response
    {
        $createError = false;
        $editError = false;
        $serviceCreateForm = $this->createForm(AircraftConsultServiceType::class);
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
        $serviceEditForm = $this->createForm(AircraftConsultServiceEditType::class);
        $serviceEditForm->handleRequest($request);
        if ($serviceEditForm->isSubmitted()) {
            if ($serviceEditForm->isValid()) {
                $service = $serviceRepository->find($serviceEditForm->get('id')->getData());
                if ($service) {
                    $service
                        ->setTitle($serviceEditForm->get('title')->getData())
                        ->setDescription($serviceEditForm->get('description')->getData())
                        ->setIsVisible($serviceEditForm->get('isVisible')->getData());
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
        return $this->render('admin/services/aircraftConsultService.html.twig',
            [
                'serviceCreateForm' => $serviceCreateForm,
                'serviceEditForm' => $serviceEditForm,
                'services' => $services,
                'createError' => $createError,
                'editError' => $editError,
            ]);
    }

    #[Route('/admin/aircraft_consult_service/delete/{id}', name: 'app_aircraft_consult_service_delete')]
    public function deleteService(
        ConsultAircraftServiceEntityRepository $serviceRepository,
                                                   $id,
        EntityManagerInterface                     $entityManager
    ): Response
    {
        $service = $serviceRepository->find($id);
        $entityManager->remove($service);
        $entityManager->flush();
        return $this->redirectToRoute("app_aircraft_consult_service");
    }

    #[Route('/admin/aircraft_consult_service/{id}/delete/image/{name}', name: 'app_aircraft_consult_service_delete_image')]
    public function deleteServiceImage(ConsultAircraftServiceEntityRepository $serviceRepository,
                                                                                  $id,
                                       EntityManagerInterface                     $entityManager): Response
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

        return $this->redirectToRoute('app_aircraft_consult_service');
    }

}