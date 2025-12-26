<?php

namespace App\Tools;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;


class APITokenProvider{
    public function __construct(
        private HttpClientInterface $iparapheurClient,
        private CacheInterface $cache,
        private string $iparapheurApiUsername,
        private string $iparapheurApiPassword,
    ){}

    public function getToken(): string
    {
        return $this->cache->get('iparapheur_api_token', function (ItemInterface $item) {
            $item->expiresAfter(300); // seconds

            $response = $this->iparapheurClient->request('POST', '/auth/realms/api/protocol/openid-connect/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
                'body' => [
                    'grant_type' => 'password',
                    'client_id' => 'ipcore-web',
                    'username' => $this->iparapheurApiUsername,
                    'password' => $this->iparapheurApiPassword,
                ]
            ]);

            $data = $response->toArray();

            return $data['access_token'];
        });
    }
}