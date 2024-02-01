<?php

namespace App\Services\ApiGateway;

use Illuminate\Support\Facades\Log;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Client\RequestExceptionInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;

class PetStoreAPIService
{
    private ClientInterface $httpClient;
    private RequestFactoryInterface $requestFactory;

    public function __construct(ClientInterface $httpClient, RequestFactoryInterface $requestFactory)
    {
        $this->httpClient = $httpClient;
        $this->requestFactory = $requestFactory;
    }

    public function sendRequest(string $method, string $endpoint, array $data = []): ResponseInterface
    {
        $uri = $this->requestFactory
            ->createRequest($method, config('petstore.host') . $endpoint)
            ->withHeader('Content-Type', 'application/json')
            ->withBody($this->requestFactory->createStream(json_encode($data)));

        try {
            return $this->httpClient->sendRequest($uri);
        } catch (RequestExceptionInterface | NetworkExceptionInterface | ClientExceptionInterface $e) {
            Log::channel('petstoreAPIError')->error("Error: {$e->getMessage()}");
            throw $e;
        }
    }
}
