<?php

namespace App\Controller\Admin;

use App\Form\SeoEditType;
use App\Form\SeoType;
use App\Repository\SeoRepository;
use App\Service\SeoService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Security('is_granted("ROLE_ADMIN")')]
class AdminSeoController extends AbstractController{
    #[Route('/admin/seo', name: 'app_admin_seo')]
    public function seo(Request                $request,
                        SeoService             $seoService,
                        SeoRepository          $seoRepository,
                        EntityManagerInterface $entityManager): Response
    {
        $seoCreateForm = $this->createForm(SeoType::class);
        $seoCreateForm->handleRequest($request);
        if ($seoCreateForm->isSubmitted() && $seoCreateForm->isValid()) {
            $seoService->create($seoCreateForm->getData());
            return $this->redirectToRoute($request->get('_route'), $request->query->all());
        }

        $seoEditForm = $this->createForm(SeoEditType::class);
        $seoEditForm->handleRequest($request);
        if ($seoEditForm->isSubmitted() && $seoEditForm->isValid()) {
            $seo = $seoRepository->find($seoEditForm->get('id')->getData());
            $seo
                ?->setTitle($seoEditForm->get('title')->getData())
                ->setDescription($seoEditForm->get('description')->getData())
                ->setPath($seoEditForm->get('path')->getData());
            $seoService->create($seo);
            return $this->redirectToRoute($request->get('_route'), $request->query->all());
        }
        $seo = $seoRepository->findAll();
        return $this->render('admin/seo.html.twig', [
            'controller_name' => 'Каркасыч (Админ - SEO)',
            'description' => 'Админка',
            'seo' => $seo,
            'seoCreateForm' => $seoCreateForm->createView(),
            'seoEditForm' => $seoEditForm->createView(),

        ]);
    }

}
