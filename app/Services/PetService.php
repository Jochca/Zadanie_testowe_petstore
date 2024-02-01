<?php

namespace App\Services;

use App\DTO\Pet\PetCategoryDTO;
use App\DTO\Pet\PetDTO;
use App\DTO\Pet\PetTagDTO;
use App\Services\ApiGateway\PetStoreAPIService;
use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Client\NetworkExceptionInterface;
use Psr\Http\Client\RequestExceptionInterface;

class PetService
{
    public function __construct(
        private PetStoreAPIService $petStoreAPIService,
    ){}

    private function responseToDTO(\stdClass $pet) : PetDTO
    {
        return new PetDTO(
            id: isset($pet->id) ? $pet->id : null,
            category: new PetCategoryDTO(
                id: isset($pet->category->id) ? $pet->category->id : null,
                name: isset($pet->category->name) ? $pet->category->name : null,
            ),
            name: isset($pet->name) ? $pet->name : null,
            photoUrls: isset($pet->photoUrls) ? $pet->photoUrls : null,
            tags: isset($pet->tags) ? $this->mapTags($pet->tags) : null,
            status: isset($pet->status) ? $pet->status : null,
        );
    }

    private function mapTags(array $tags): array
    {
        return array_map(function($tag) {
            return new PetTagDTO(
                id: isset($tag->id) ? $tag->id : null,
                name: isset($tag->name) ? $tag->name : null,
            );
        }, $tags);
    }

    public function index(string $status) : array
    {
        try{
            $response = $this->petStoreAPIService->sendRequest(method: 'GET', endpoint: config('petstore.endpoints.pets.index')."?status=$status");
        } catch (RequestExceptionInterface | NetworkExceptionInterface | ClientExceptionInterface $e) {
            throw $e;
        }

        $pets = json_decode($response->getBody()->getContents());

        return array_map([$this, 'responseToDTO'], $pets);
    }

    public function store(PetDTO $petDTO) : PetDTO
    {
        try{
            $response = $this->petStoreAPIService->sendRequest(method: 'POST', endpoint: config('petstore.endpoints.pets.store'), data: [
                'id' => $petDTO->id,
                'category' => $petDTO->category,
                'name' => $petDTO->name,
                'photoUrls' => $petDTO->photoUrls,
                'tags' => $petDTO->tags,
                'status' => $petDTO->status,
            ]);
        } catch (RequestExceptionInterface | NetworkExceptionInterface | ClientExceptionInterface $e) {
            throw $e;
        }

        $response = json_decode($response->getBody()->getContents());

        return $this->responseToDTO($response);
    }

    public function update(PetDTO $petDTO) : PetDTO
    {
        try{
            $response = $this->petStoreAPIService->sendRequest(method: 'PUT', endpoint: config('petstore.endpoints.pets.update'), data: [
                'id' => $petDTO->id,
                'category' => $petDTO->category,
                'name' => $petDTO->name,
                'photoUrls' => $petDTO->photoUrls,
                'tags' => $petDTO->tags,
                'status' => $petDTO->status,
            ]);
        } catch (RequestExceptionInterface | NetworkExceptionInterface | ClientExceptionInterface $e) {
            throw $e;
        }

        $response = json_decode($response->getBody()->getContents());

        return $this->responseToDTO($response);
    }
}
