<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cp extends Model
{
    use HasFactory;

    public function localidade() {
        return $this->belongsTo(Localidade::class);
    }
    public function domicilios() {
        return $this->hasMany(Domicilio::class, 'codigo_postal');
    }
}
