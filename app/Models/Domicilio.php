<?php

namespace App\Models;

use Faker\Provider\ar_JO\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Domicilio extends Model
{
    use HasFactory;

    public function cp() {
        return $this->belongsTo(Cp::class, 'codigo_postal');
    }
    public function personas() {
        return $this->hasMany(Persona::class, 'domicilio');
    }
}
