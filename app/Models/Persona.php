<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    // Oculta de las busquedas
    protected $hidden = [
        'domicilio',
        'padre',
        'madre',

        'created_at',
        'updated_at'
    ];
}
