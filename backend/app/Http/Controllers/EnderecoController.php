<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnderecoRequest;
use App\Models\Endereco;
use Exception;

class EnderecoController extends Controller
{
    public function index()
    {
        try {
            $user = auth('api')->user();
            $endereco = Endereco::where('user_id', $user->id)->first();

            if (!$endereco) throw new \Exception("Endereço não encontrado.", 404);

            return response()->json($endereco);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function store(EnderecoRequest $request)
    {
        try {
            $user = auth('api')->user();
            if ($user->tipo_usuario !== 1) throw new \Exception("Usuário não autorizado", 403);

            $endereco = Endereco::create([
                'user_id' => $user->id,
                ...$request->validated(),
            ]);

            return response()->json([
                'message' => 'Endereço cadastrado com sucesso!',
                'endereco' => $endereco
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    public function update(EnderecoRequest $request)
    {
        try {
            $user = auth('api')->user();

            if ($user->tipo_usuario !== 1) throw new \Exception("Usuário não autorizado.", 403);

            $endereco = $user->endereco;

            if (!$endereco) throw new \Exception("Nenhum endereço encontrado para atualizar.", 404);

            $endereco->update($request->validated());

            return response()->json([
                'message' => 'Endereço atualizado com sucesso!',
                'endereco' => $endereco
            ]);
        } catch (\Exception $e) {
            return $this->handleException($e);
        }
    }

    private function handleException(\Exception $e)
    {
        $status = $e->getCode() ?: 500;

        if (!in_array($status, [403, 404, 500])) {
            $status = 500;
        }

        return response()->json([
            'error' => $e->getMessage()
        ], $status);
    }
}
