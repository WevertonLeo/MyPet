<?php

use App\Http\Controllers\API\PetController;
use Illuminate\Support\Facades\Route;

Route::post('/pets', [PetController::class, 'store']);
Route::get('/pets', [PetController::class, 'index']);