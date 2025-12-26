<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\Mime\Part\DataPart;
use Symfony\Component\Mime\Part\Multipart\FormDataPart;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Tools\APITokenProvider;
use Symfony\Component\HttpFoundation\JsonResponse;

class IparapheurService
{
    private string $iparapheurApiUrl;
    private string $firstDeskId;

    public function __construct(
        private readonly HttpClientInterface $iparapheurClient,
        private APITokenProvider $tokenProvider
    ){
        $this->iparapheurApiUrl = '/api/standard/v1';
        $this->firstDeskId = 'de69b585-c90f-4c70-b52e-615222d92f2d';
    }


    public function request(string $method, string $path, array $options = []): ResponseInterface
    {
        // On injecte dynamiquement le token dans les headers
        $options['headers']['Authorization'] = 'Bearer ' . $this->tokenProvider->getToken();
        return $this->iparapheurClient->request($method, $this->iparapheurApiUrl . $path, $options);
    }


    public function createDirectory(UploadedFile $xmlProperties, UploadedFile $fileContent): ResponseInterface
    {
        $tenant = $this->getTenant();
        $initialDesk = $this->getInitialDesk($tenant);
        $initialDeskId = $initialDesk['id'];

        if ($xmlProperties instanceof UploadedFile) {
            // On convertit l'UploadedFile en DataPart
            $xmlProperties = DataPart::fromPath($xmlProperties->getPathname(), $xmlProperties->getClientOriginalName());
        }

        $body = [
            'folder' => $xmlProperties,
            'documents' => DataPart::fromPath(
                $fileContent->getPathname(), 
                $fileContent->getClientOriginalName(), 
                'application/pdf'
            ),
        ];

        $formData = new FormDataPart($body);
        $headers = $formData->getPreparedHeaders()->toArray();

        /* Exemple de réponse 
        {
            "id":"835694de-e26c-11f0-946c-f24485ed78f5",
            "name":"TEST API 3",
            "dueDate":null,
            "metadata": {
                "i_Parapheur_reserved_ext_sig_firstname":"Kilian",
                "i_Parapheur_reserved_ext_sig_phone":"0782978575",
                "i_Parapheur_reserved_ext_sig_lastname":"VIOLET",
                "i_Parapheur_reserved_ext_sig_mail":"kilian.vlt1@gmail.com"
            }
        }
        */

        return $this->request('POST', "/tenant/$tenant/desk/$initialDeskId/folder", [
            'headers' => $headers,
            'body' => $formData->bodyToIterable(),
        ]);
    }


    private function getTenant(): string
    {
        $response = $this->request('GET', '/tenant');

        if( $response->getStatusCode() !== 200 ){
            throw new \Exception('Unable to fetch tenant information from Iparapheur API.');
        }

        $data = $response->toArray();
        return $data['content'][0]['id'];
    }


    private function getInitialDesk(string $tenant): array
    {
        $response = $this->request('GET', "/tenant/$tenant/desk");

        if( $response->getStatusCode() !== 200 ){
            throw new \Exception('Unable to fetch desks informations from Iparapheur API.');
        }

        $data = $response->toArray();

        $initialDesk = array_filter($data['content'], function($desk) {
            return $desk['id'] === $this->firstDeskId;
        });

        if (empty($initialDesk)) {
            throw new \Exception('Initial desk not found in Iparapheur API response.');
        }

        return $initialDesk[array_key_first($initialDesk)];
    }

}