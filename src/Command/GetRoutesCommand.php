<?php

namespace App\Command;

use App\Entity\Seo;
use App\Kernel;
use App\Repository\SeoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\CommandLoader\ContainerCommandLoader;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\Container;

use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Component\Routing\Router;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

#[AsCommand(
    name: 'app:get-routes',
    description: 'Add a short description for your command',
)]
class GetRoutesCommand extends Command
{
    private SeoRepository $seoRepository;
    private EntityManagerInterface $entityManager;
    public function __construct(
        private Kernel $kernel,
        SeoRepository $seoRepository,
        EntityManagerInterface $entityManager
    ){
        $this->entityManager = $entityManager;
        $this->seoRepository = $seoRepository;
        $this->container = $kernel->getContainer();
        parent::__construct();
    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $routes = $this->routeAction();
        foreach ($routes as $route) {
            if (!$this->seoRepository->findBy([
                'path' => $route
            ])){
                $seo = new Seo();
                $seo->setPath($route);
                $this->entityManager->persist($seo);
            }
        }
        $this->entityManager->flush();
        return Command::SUCCESS;
    }

    public function routeAction()
    {
        /** @var Router $router */
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        $router = $this->container->get('router');
        $routes = $router->getRouteCollection();
        $routes = $serializer->normalize($routes);
        $routesArr = [];
        foreach ($routes as $route) {
            if (!str_starts_with($route['path'], "/_") && !str_starts_with($route['path'], "/admin")) {
                $routesArr[] = $route['path'];
            }
        }
        return $routesArr;

    }
}
