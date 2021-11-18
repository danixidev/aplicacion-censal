<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidade extends Model
{
    use HasFactory;

    public function provinciapadre() {
        return $this->belongsTo(Provincia::class, 'id');
    }
    public function cphija() {
        return $this->hasMany(Cp::class, 'codigo_postal');
    }
}
