<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    use HasFactory;

    public function comunidade() {
        return $this->belongsTo(Comunidade::class, 'comunidad_id');
    }
    public function localidades() {
        return $this->hasMany(Localidade::class);
    }
}
