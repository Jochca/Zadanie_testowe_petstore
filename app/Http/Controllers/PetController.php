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
        private PetService $petStoreAPIGatewayService,
    ){}

    public function index(PetIndexRequest $request) : View
    {
        try{
            $pets = $this->petStoreAPIGatewayService->index($request->status);
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'pets' => $pets,
            'action' => 'index',
        ]);
    }

    public function store(PetStoreRequest $request) : View
    {
        try{
            $pet = $this->petStoreAPIGatewayService->store($request->toDTO());
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'pets' => [$pet],
            'action' => 'store',
        ]);
    }

    public function update(PetUpdateRequest $request) : View
    {
        try{
            $pet = $this->petStoreAPIGatewayService->update($request->toDTO());
        } catch (\Exception $e) {
            return view('pets.index', [
                'pets' => [],
                'ApiError' => true,
            ]);
        }

        return view('pets.index', [
            'pets' => [$pet],
            'action' => 'update',
        ]);
    }
}
