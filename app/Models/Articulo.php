<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Articulo extends Model
{
    protected $fillable = ['titulo', 'resumen', 'contenido', 'categoria', 'imagen'];

    public function imagenRegistro(): BelongsTo
    {
        return $this->belongsTo(Imagen::class, 'imagen', 'ruta');
    }
}
