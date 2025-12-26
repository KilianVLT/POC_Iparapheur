<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\IparapheurService;

final class SubventionController extends AbstractController
{
    private IparapheurService $iparapheurService;

    public function __construct(IparapheurService $iparapheurService)
    {
        $this->iparapheurService = $iparapheurService;
    }

    #[Route('/subvention', name: 'app_subvention')]
    public function index(): Response
    {
        return $this->render('subvention/index.html.twig', [
            'controller_name' => 'SubventionController',
        ]);
    }


}
