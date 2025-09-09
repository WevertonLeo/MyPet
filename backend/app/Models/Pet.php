<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'cor',
        'raca',
        'status_id',
        'rua',
        'bairro',
        'cidade',
        'estado',
        'cep',
    ];
}
