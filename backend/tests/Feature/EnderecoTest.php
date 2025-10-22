<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnderecoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function instituicao_pode_cadastrar_endereco()
    {
        $user = User::factory()->create(['tipo_usuario' => 1]);

        $response = $this->actingAs($user, 'api')->postJson('/api/enderecos', [
            'cep' => '12345-678',
            'logradouro' => 'Rua das Flores',
            'numero' => '10',
            'complemento' => 'Apto 201',
            'bairro' => 'Centro',
            'cidade' => 'São Paulo',
            'estado' => 'SP',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure(['message', 'endereco']);
    }

    /** @test */
    public function usuario_comum_nao_pode_cadastrar_endereco()
    {
        $user = User::factory()->create(['tipo_usuario' => 0]);

        $response = $this->actingAs($user, 'api')->postJson('/api/enderecos', [
            'cep' => '00000-000',
            'logradouro' => 'Rua X',
            'cidade' => 'RJ',
            'estado' => 'RJ',
        ]);

        $response->assertStatus(403);
    }
}
