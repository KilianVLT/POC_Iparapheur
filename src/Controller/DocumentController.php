<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\DocumentService;

use function PHPUnit\Framework\isEmpty;

#[Route('/api/documents')]
final class DocumentController extends AbstractController
{

    public function __construct(
        private DocumentService $documentService
    )
    {
        $this->documentService = $documentService;
    }

    #[Route('/', name: 'app_document')]
    public function index(): Response
    {
        return $this->render('document/index.html.twig', [
            'controller_name' => 'DocumentController',
        ]);
    }

    
    #[Route('/create', name: 'app_document_create')]
    public function create(Request $request): Response
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        if(!is_array($data)) return new Response('Invalid data', Response::HTTP_BAD_REQUEST);
        if(empty($data)) return new Response('No data provided', Response::HTTP_BAD_REQUEST);

        $this->documentService->createMany($data);
        return new Response('Documents created successfully', Response::HTTP_CREATED);
    }    

}
