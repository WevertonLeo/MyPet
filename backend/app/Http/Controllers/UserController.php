<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $result = $this->service->register($request->validated());

        return response()->json([
            'user' => $result['user'],
            'token' => $result['token']
        ], 201);
    }
}
