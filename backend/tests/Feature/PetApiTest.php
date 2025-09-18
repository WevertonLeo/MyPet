<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PetApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_pet()
    {
        $response = $this->postJson('/api/pets', [
            'nome' => 'Rex',
            'cor' => 'Preto',
            'raca' => 'Vira-lata',
            'status_id' => 1,
            'rua' => 'Rua A',
            'bairro' => 'Centro',
            'cidade' => 'Belo Horizonte',
            'estado' => 'MG',
            'cep' => '30123-456',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('pets', ['nome' => 'Rex', 'raca' => 'Vira-lata']);
    }
}
