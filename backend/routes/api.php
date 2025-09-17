<?php

use App\Http\Controllers\API\PetController;
use Illuminate\Support\Facades\Route;

Route::prefix('pets')
->controller(PetController::class)
->name('pets.')
->group(function (){
    Route::get('/', [PetController::class, 'index']);
    Route::post('/', [PetController::class, 'store']);
});