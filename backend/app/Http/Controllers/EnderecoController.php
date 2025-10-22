<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use Illuminate\Support\Facades\Auth;

class EnderecoController extends Controller
{
    public function store(EnderecoRequest $request)
    {
        $user = auth('api')->user();

        if ($user->tipo_usuario !== 1) {
            return response()->json(['error' => 'Usuário não autorizado'], 403);
        }

        $endereco = Endereco::create([
            'user_id' => $user->id,
            ...$request->validated(),
        ]);

        return response()->json([
            'message' => 'Endereço cadastrado com sucesso!',
            'endereco' => $endereco
        ]);
    }

    public function show()
    {
        $user = auth('api')->user();

        $endereco = $user->endereco;

        if (!$endereco) {
            return response()->json(['message' => 'Nenhum endereço encontrado'], 404);
        }

        return response()->json($endereco);
    }
}
