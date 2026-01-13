<?php

namespace App\Scheduler\Task;

use Symfony\Component\Scheduler\Attribute\AsPeriodicTask;
use App\Service\KiosqueService;

// defines the method name to call instead as well as the arguments to pass to it
#[AsPeriodicTask(frequency: '1 day', method: 'checkSignableDocuments')]
class SendDailySalesReports
{

    public function __construct(
        private KiosqueService $kiosqueService
    ) {}

    public function checkSignableDocuments(): void
    {
        $this->kiosqueService->getFeaderFolders('0030');
        
        // Add to bdd
        // ...
    }
}
