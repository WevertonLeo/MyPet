<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CepService
{
    public function buscarCep(string $cep)
    {
        $cep = preg_replace('/[^0-9]/', '', $cep); // remove traços e pontos

        if (strlen($cep) !== 8) {
            return null;
        }

        $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

        if ($response->failed() || isset($response['erro'])) {
            return null;
        }

        return [
            'cep' => $response['cep'],
            'rua' => $response['logradouro'],
            'bairro' => $response['bairro'],
            'cidade' => $response['localidade'],
            'estado' => $response['uf'],
        ];
    }
}
