<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Component\HttpClient\Response\TraceableResponse;
use App\Tools\GraphQLQueryMaker;
use App\Tools\XMLFileGenerator;

class KiosqueService
{

    public function __construct(
        private readonly HttpClientInterface $kiosqueClient,
        private GraphQLQueryMaker $graphQLQueryMaker,
        private XMLFileGenerator $xmlFileGenerator
    ){}


    public function getFeaderFolders($ref): array
    {
        if (empty($ref) || $ref == "" || $ref == null) {
            return [];
        }

        $query = $this->graphQLQueryMaker->makeGraphQLQuery($ref);

        $response = $this->kiosqueClient->request('POST', '/pda-semi-public-api/api/agent-ged/graphql', [
            "headers" => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode($_ENV['KIOSQUE_API_USERNAME'] . ':' . $_ENV['KIOSQUE_API_PASSWORD']),
                'x-tenant-id' => $_ENV['KIOSQUE_API_TENANT_ID']
            ],
            "json" => [
                'query' => $query,
            ]
        ]);

        return $response->toArray();
    }

    function getFeaderDocument(string $filename): TraceableResponse
    {
        // $response = $this->kiosqueClient->request('GET', '/pda-semi-public-api/api/tenants/crauraprod/agent-ged/documents/' . $filename , [
        //     "headers" => [
        //         'Content-Type' => 'application/json',
        //         'Authorization' => 'Basic ' . base64_encode($_ENV['KIOSQUE_API_USERNAME'] . ':' . $_ENV['KIOSQUE_API_PASSWORD']),
        //         'x-tenant-id' => $_ENV['KIOSQUE_API_TENANT_ID']
        //     ]
        // ]);

        $data = [
            'folder' => [
                'i_Parapheur_reserved_type' => 'DOCUMENTS PDF',
                'i_Parapheur_reserved_subtype' => 'Pièce PDA',
                'i_Parapheur_reserved_ext_sig_firstname' => 'Kilian',
                'i_Parapheur_reserved_ext_sig_lastname' => 'VIOLET',
                'i_Parapheur_reserved_ext_sig_mail' => 'kilian.vlt1@gmail.com',
                'i_Parapheur_reserved_ext_sig_phone' => '0782978575'
            ],
            'folderName' => 'TEST API 3',
            'file' => [
                'i_Parapheur_reserved_mainDocument' => 'true',
            ],
            'fileName' => 'balise.pdf'
        ];
        dd($this->xmlFileGenerator->generateXMLFile($data));
        
        return $response;        
    }
}