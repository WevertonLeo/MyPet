<?php

namespace App\Http\Controllers;

use App\Services\CepService;

class CepController extends Controller
{
    protected $cepService;

    public function __construct(CepService $cepService)
    {
        $this->cepService = $cepService;
    }

    public function show($cep)
    {
        $data = $this->cepService->buscarCep($cep);

        if (!$data) {
            return response()->json(['message' => 'CEP não encontrado'], 404);
        }

        return response()->json($data, 200);
    }
}
