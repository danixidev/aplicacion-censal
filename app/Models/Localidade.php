<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localidade extends Model
{
    use HasFactory;

    public function provincia() {
        return $this->belongsTo(Provincia::class);
    }
    public function cps() {
        return $this->hasMany(Cp::class, 'localidad_id');
    }
}
