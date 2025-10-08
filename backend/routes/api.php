<?php

use App\Http\Controllers\API\PetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('pets')
->controller(PetController::class)
->group(function (){
    Route::get('/', 'index');
    Route::post('/', 'store');
});

Route::prefix('user')
->controller(UserController::class)
->group(function (){
    Route::get('/', 'index');
    Route::post('/', 'store');
});
