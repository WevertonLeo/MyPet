<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserService
{
    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function register(array $data): array
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->repository->create($data);
        $token = auth('api')->login($user);

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(string $email, string $password): ?array
    {
        $credentials = ['email' => $email, 'password' => $password];
        
        if (!$token = auth('api')->attempt($credentials)) {
            return null;
        }

        return [
            'user' => auth('api')->user(),
            'token' => $token
        ];
    }

    public function logout(): void
    {
        auth('api')->logout();
    }

    public function refresh(): string
    {
        return auth('api')->refresh();
    }

    public function getCurrentUser(): ?User
    {
        return auth('api')->user();
    }
}
