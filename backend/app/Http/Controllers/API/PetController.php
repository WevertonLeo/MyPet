<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePetRequest;
use App\Models\Pet;

class PetController extends Controller
{

    public function index()
    {
        return response()->json(Pet::all(), 200);
    }

    public function store(StorePetRequest $request)
    {
        $pet = Pet::create($request->validated());
        return response()->json($pet, 201);
    }
}