<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Intento extends Model
{
    protected $fillable = ['puntaje_total', 'nivel'];

    public function respuestas(): HasMany
    {
        return $this->hasMany(Respuesta::class);
    }
}
