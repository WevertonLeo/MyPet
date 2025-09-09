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
            'nome' => 'Maximus',
            'cor' => 'Branco',
            'raca' => 'Cachorro',
            'status_id' => 1,
            'rua' => 'Dez',
            'bairro' => 'Neviana',
            'cidade' => 'Ribeirao Das Neves',
            'estado' => 'Minas Gerais',
            'cep' => '33.808-100',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['nome' => 'Maximus', 'cidade' => 'Ribeirao Das Neves']);

        $this->assertDatabaseHas('pets', ['nome' => 'Maximus']);
    }
}
