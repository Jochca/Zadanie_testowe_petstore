<?php

namespace App\DTO\Pet;

class PetTagDTO
{
    public $id;
    public $name;

    public function __construct(
        ?int $id,
        ?string $name,
    ) {
        $this->id = $id;
        $this->name = $name;
    }
}
