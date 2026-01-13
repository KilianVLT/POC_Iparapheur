<?php

namespace App\Tools\Worker;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use App\Tools\Worker\CheckUrl;

#[AsMessageHandler]
class CheckUrlHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private HttpClientInterface $httpClient
    ) {}

    public function __invoke(CheckUrl $message)
    {
        $response = $this->httpClient->request('GET', $message->getUrl());
        $this->logger->alert(sprintf(
            'Monitored url "%s", response status code is "%s"',
            $message->getUrl(),
            $response->getStatusCode()
        ));
    }
}
