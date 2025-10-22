<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CepController;
use App\Http\Controllers\EnderecoController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {

    Route::controller(AuthController::class)
    ->prefix('auth')
    ->group(function (){
        Route::get('/me',       'me');
        Route::post('/logout',  'logout');
        Route::post('/refresh', 'refresh');
    });

    Route::controller(EnderecoController::class)
    ->group(function(){
        Route::post('/enderecos', 'store');
        Route::get('/enderecos', 'show');
    });

});

Route::get('/cep/{cep}', [CepController::class, 'show']);
