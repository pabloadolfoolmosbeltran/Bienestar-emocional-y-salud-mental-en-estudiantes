<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pregunta extends Model
{
    protected $fillable = ['texto', 'categoria', 'orden', 'activa'];

    protected function casts(): array
    {
        return ['activa' => 'boolean'];
    }

    public function opciones(): HasMany
    {
        return $this->hasMany(Opcion::class);
    }
}
