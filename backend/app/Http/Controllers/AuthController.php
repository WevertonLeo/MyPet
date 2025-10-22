<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $auth = $this->service->login($credentials['email'], $credentials['password']);

        if (!$auth) {
            return response()->json(['error' => 'Credenciais inválidas'], 401);
        }

        return response()->json($auth);
    }

    public function logout(): JsonResponse
    {
        $this->service->logout();
        return response()->json(['message' => 'Logout realizado com sucesso']);
    }

    public function refresh(): JsonResponse
    {
        $token = $this->service->refresh();
        return response()->json(['token' => $token]);
    }

    public function me(): JsonResponse
    {
        return response()->json($this->service->getCurrentUser());
    }
}
