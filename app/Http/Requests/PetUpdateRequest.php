<?php

namespace App\Http\Requests;

use App\DTO\Pet\PetCategoryDTO;
use App\DTO\Pet\PetDTO;
use App\DTO\Pet\PetTagDTO;
use Illuminate\Foundation\Http\FormRequest;

class PetUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'status' => 'string|nullable',
            'name' => 'string|nullable',
            'category' => 'string|nullable',
            'photoUrls' => 'string|nullable',
            'tags' => 'string|nullable',
            'id' => 'integer',
        ];
    }

    public function toDTO(): PetDTO
    {
        $tags = [];
        if($this->get('tags') != null) {
            foreach (json_decode($this->get('tags')) as $tag) {
                $tags[] = new PetTagDTO(
                    id: null,
                    name: $tag,
                );
            }
        }

        return new PetDTO(
            id: $this->get('id'),
            category: new PetCategoryDTO(
                id: null,
                name: $this->get('category'),
            ),
            name: $this->get('name'),
            photoUrls: [
                $this->get('photoUrls'),
            ],
            tags: $tags,
            status: $this->get('status'),
        );
    }
}
