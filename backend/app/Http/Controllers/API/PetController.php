<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pet;
use Illuminate\Http\Request;

class PetController extends Controller
{
    public function store(Request $request)
    {
        $pet = Pet::create($request->all());
        return response()->json($pet, 201);
    }

    public function index()
    {
        return response()->json(Pet::all());
    }
}