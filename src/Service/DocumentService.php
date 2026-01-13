<?php

namespace App\Service;

use App\Entity\Document;
use Doctrine\ORM\EntityManagerInterface;

class DocumentService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
    }
    

    public function createMany(array $dataList): void
    {
        foreach($dataList as $data){
            $this->createDocument($data);
        }
    }


    public function createDocument(array $data): void
    {
        $document = new Document();
        $document->setGedId($data['ged_id']);
        $document->setDocumentName($data['document_name']);
        $document->setResponsableName($data['responsable_name']);
        $document->setResponsableSurname($data['responsable_surname']);
        $document->setType($data['type']);
        $document->setSubtype($data['subtype']);
        $document->setStatus($data['status']);
        $document->setLastUpdate(new \DateTime());
        $this->entityManager->persist($document);
        $this->entityManager->flush();
    }
}