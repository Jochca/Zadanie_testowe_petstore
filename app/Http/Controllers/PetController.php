<?php

namespace App\Http\Controllers;

use App\Http\Requests\PetIndexRequest;
use App\Http\Requests\PetStoreRequest;
use App\Http\Requests\PetUpdateRequest;
use App\Services\PetService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PetController extends Controller
{
    public function __construct(
        private PetService $petService,
    ){}

    public function index(PetIndexRequest $request) : View
    {
        try{
            $pets = $this->petService->index($request->status);
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'pets' => $pets,
        ]);
    }

    public function store(PetStoreRequest $request) : View
    {
        try{
            $pet = $this->petService->store($request->toDTO());
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'pets' => [$pet],
            'message' => 'Pet created successfully!',
        ]);
    }

    public function update(PetUpdateRequest $request) : View
    {
        try{
            $pet = $this->petService->update($request->toDTO());
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'pets' => [$pet],
            'message' => 'Pet updated successfully!',
        ]);
    }

    public function destroy(Request $request) : View
    {
        try{
            $this->petService->destroy($request->id);
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'message' => 'Pet deleted successfully!',
        ]);
    }
}
