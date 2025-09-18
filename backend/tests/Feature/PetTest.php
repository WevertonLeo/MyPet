<?php

namespace Tests\Feature;

use App\Models\Pet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PetTest extends TestCase
{
    use RefreshDatabase;

    public function test_criar_pet(): void
    {

        $pet = Pet::create([
            'nome' => 'Maximus',
            'cor' => 'Branco',
            'raca' => 'Cachorro',
            'status_id' => 1,
            'rua' => null,
            'bairro' => 'Neviana',
            'cidade' => 'Ribeirao Das Neves',
            'estado' => 'Minas Gerais',
            'cep' => '33.808-100',
        ]);

        $this->assertDatabaseHas('pets', ['nome' => 'Maximus']);
    }
}
