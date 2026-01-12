<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\KiosqueService;

#[Route('/api')]
final class SubventionController extends AbstractController
{
    private KiosqueService $kiosqueService;

    public function __construct(KiosqueService $kiosqueService)
    {
        $this->kiosqueService = $kiosqueService;
    }


    #[Route('/feader/folders/{ref}', name: 'get_feader_folders')]
    public function getFeaderFolders(string $ref): Response
    {
        $response = $this->kiosqueService->getFeaderFolders($ref);
        return $this->json($response);
    }

    
    #[Route('/feader/document/{filename}', name: 'get_feader_document')]
    public function getFeaderDocument(string $filename): Response
    {
        $response = $this->kiosqueService->getFeaderDocument($filename);
        return new Response($response->getContent(), 200, [
            'Content-Type' => $response->getHeaders()['content-type'][0],
            'Content-Disposition' => 'attachment; filename="' . $filename . '"'
        ]);
    }
}