<?php

namespace App\Controller;
use App\Repository\Medicament;
use App\Repository\MedicamentRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Medicament as MedicamentEntity;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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

    #[Route('/medicaments', name: 'medicaments')]
    public function listMedicaments(MedicamentRepository $medicamentRepository): Response
    {
        $medicaments = $medicamentRepository->findAll();

        return $this->render('app/medicaments.html.twig', [
            'medicaments' => $medicaments,
        ]);
    }

    #[Route("/medicaments/{id}/delete", name: "medicament_delete", methods: ["POST"])]
    public function delete(MedicamentEntity $medicament, Request $request, MedicamentRepository $medicamentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$medicament->getId(), $request->request->get('_token'))) {
            // You can directly call the repository method to delete the entity
            $medicamentRepository->delete($medicament);
    
            // Add a flash message
            $this->addFlash('success', 'Medication deleted successfully.');
        }
    
        // Redirect to a page after deletion (e.g., list of medications)
        return $this->redirectToRoute('medicaments');
    }
}
