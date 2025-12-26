<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\IparapheurService;

class IparapheurController extends AbstractController
{
    private IparapheurService $iparapheurService;

    public function __construct(IparapheurService $iparapheurService)
    {
        $this->iparapheurService = $iparapheurService;
    }


    #[Route('/iparapheur', name: 'app_iparapheur')]
    public function index(): Response
    {
        return $this->render('iparapheur/index.html.twig', [
            'controller_name' => 'IparapheurController',
        ]);
    }


    // Obtenir le tenant (GET)
    #[Route('/iparapheur/tenant', name: 'app_iparapheur_tenant')]
    public function getTenant(): Response
    {
        $response = $this->iparapheurService->request('GET', '/tenant');
        $data = $response->toArray();

        return $this->json($data);
    }

    
    // Créer un dossier (POST)
    #[Route('/iparapheur/directory', name: 'app_iparapheur_create_directory', methods: ['POST'])]
    public function createDirectory(Request $request): Response
    {
        $xmlProperties = $request->files->get('folder');
        $fileContent = $request->files->get('documents');

        if($xmlProperties && $fileContent){
            $response = $this->iparapheurService->createDirectory($xmlProperties, $fileContent);
            return $this->json($response);
        } else {
            return $this->json(['error' => 'Missing folder or documents data'], Response::HTTP_BAD_REQUEST);
        }
    }

    // Obtenir les bureaux (GET)
    
    // Récupérer le fichier (GET)
}