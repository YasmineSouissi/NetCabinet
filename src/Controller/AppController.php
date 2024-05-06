<?php

namespace App\Controller;
use App\Repository\Medicament;
use App\Repository\MedicamentRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Medicament as MedicamentEntity;
use App\Form\MedicamentType;
use App\Entity\Ordonnance;
use App\Form\OrdonnanceType;

use App\Repository\OrdonnanceRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;


class AppController extends AbstractController
{
    #[Route('/', name: 'app_app')]
    public function index()
    {

        return $this->render('app/index.html.twig');
    }
    #[Route('/login', name: 'login')]
    public function login(): Response
    {
        return $this->render('app/login.html.twig');
    }
    #[Route('/dashboard', name: 'dashboard')]
    public function dashboard()
    {

        return $this->render('app/dashboard.html.twig');
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
    #[Route('/nouveau_med', name: 'nouveau_med')]
    public function new(Request $request, MedicamentRepository $medicamentRepository): Response
    {
        // Create a new instance of the entity Medicament
        $medicament = new MedicamentEntity();
    
        // Create a form instance using the MedicamentType form type
        $form = $this->createForm(MedicamentType::class, $medicament);
    
        // Handle form submission
        $form->handleRequest($request);
    
        // Check if the form is submitted and valid
        if ($form->isSubmitted() && $form->isValid()) {
            // If the form is submitted and valid, save the Medicament entity using the repository
            $medicamentRepository->save($medicament);
    
            // Add a flash message to indicate that the medication has been successfully added
            $this->addFlash('success', 'Le médicament a été ajouté avec succès.');
    
            // Redirect the user to another page (e.g., the list of medications)
            return $this->redirectToRoute('medicaments');
        }
    
        // Render the Twig view with the form
        return $this->render('app/nouveau_med.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
        #[Route('/ordonnances', name: 'ordonnances')]
        public function ordonnances(OrdonnanceRepository $ordonnanceRepository): Response
        {
            // Récupérer toutes les ordonnances en utilisant la méthode personnalisée du repository
            $ordonnances = $ordonnanceRepository->findAllOrdonnances();
    
            // Passer les ordonnances à la vue Twig
            return $this->render('app/ordonnance.htlm.twig', [
                'ordonnances' => $ordonnances,
            ]);
        }
        #[Route('/nouvelle_ordonnance', name: 'nouvelle_ordonnance')]
        public function nouvelleOrdonnance(Request $request): Response
        {
            // Créez une nouvelle instance de l'entité Ordonnance
            $ordonnance = new Ordonnance();
        
            // Créez une instance de votre formulaire en utilisant le formulaire de type OrdonnanceType
            $form = $this->createForm(OrdonnanceType::class, $ordonnance);
        
            // Gérez la soumission du formulaire
            $form->handleRequest($request);
        
            // Vérifiez si le formulaire est soumis et valide
            if ($form->isSubmitted() && $form->isValid()) {
                // Si le formulaire est soumis et valide, sauvegardez l'entité Ordonnance dans la base de données
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($ordonnance);
                $entityManager->flush();
        
                // Ajoutez un message flash pour indiquer que l'ordonnance a été ajoutée avec succès
                $this->addFlash('success', 'L\'ordonnance a été ajoutée avec succès.');
        
                // Redirigez l'utilisateur vers une autre page (par exemple, la liste des ordonnances)
                return $this->redirectToRoute('ordonnances');
            }
        
            // Rendez la vue Twig avec le formulaire
            return $this->render('app/nouvelle_ordonnace.html.twig', [
                'form' => $form->createView(),
            ]);
        }
        
    
}

