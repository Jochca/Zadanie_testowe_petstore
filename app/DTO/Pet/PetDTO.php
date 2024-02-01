<?php

namespace App\DTO\Pet;

class PetDTO
{
    public $id;
    public $category;
    public $name;
    public $photoUrls;
    public $tags;
    public $status;

    public function __construct(
        ?int $id,
        ?PetCategoryDTO $category,
        ?string $name,
        ?array $photoUrls,
        ?array $tags,
        ?string $status,
    ) {
        $this->id = $id;
        $this->category = $category;
        $this->name = $name;
        $this->photoUrls = $photoUrls;
        $this->tags = $tags;
        $this->status = $status;
    }

}
