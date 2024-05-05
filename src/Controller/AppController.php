<?php

namespace App\Controller;
use App\Repository\Medicament;
use App\Repository\MedicamentRepository;
use Doctrine\Persistence\ManagerRegistry;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route('/app', name: 'app_app')]
    public function index(MedicamentRepository $repo): Response
    {
        $medicaments = $repo->findAll();
        
        return $this->render('app/index.html.twig', [ 'controller_name'=>'AppController',
            'medicaments' => $medicaments,
        ]);
    }
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('app/login.html.twig');
    }
}
