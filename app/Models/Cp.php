<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cp extends Model
{
    use HasFactory;

    public function comunidadpadre() {
        return $this->belongsTo(Comunidade::class, 'id');
    }
    public function localidadhija() {
        return $this->hasMany(Localidade::class, 'localidad_id');
    }
}
