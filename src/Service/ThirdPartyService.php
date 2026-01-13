<?php

namespace App\Service;

use App\Entity\ThirdParty;
use Doctrine\ORM\EntityManagerInterface;

class ThirdPartyService
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    ) {
        $this->entityManager = $entityManager;
    }
                

    public function create(array $data): void    {
        $thirdParty = new ThirdParty();
        $thirdParty->setName($data['name']);
        $thirdParty->setSurname($data['surname']);
        $thirdParty->setPhone($data['phone']);
        $thirdParty->setMail($data['mail']);
        $thirdParty->setGedId($data['ged_id']);
        $this->entityManager->persist($thirdParty);
        $this->entityManager->flush();
    }
}