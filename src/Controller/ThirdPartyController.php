<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\ThirdPartyService;

#[Route('/api/thirdparties')]
final class ThirdPartyController extends AbstractController
{

    public function __construct(
        private ThirdPartyService $thirdPartyService
    )
    {
        $this->thirdPartyService = $thirdPartyService;
    }

    #[Route('/', name: 'app_third_party')]
    public function index(): Response
    {
        return $this->render('third_party/index.html.twig', [
            'controller_name' => 'ThirdPartyController',
        ]);
    }


    #[Route('/create', name: 'app_third_party_create')]
    public function create(Request $request): Response
    {
        $content = $request->getContent();
        $data = json_decode($content, true);
        if(!is_array($data)) return new Response('Invalid data', Response::HTTP_BAD_REQUEST);
        if(empty($data)) return new Response('No data provided', Response::HTTP_BAD_REQUEST);

        $this->thirdPartyService->create($data);
        return new Response('Third party created successfully', Response::HTTP_CREATED);
    }
}