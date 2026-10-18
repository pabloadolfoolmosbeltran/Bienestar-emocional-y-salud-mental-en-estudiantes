<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Respuesta extends Model
{
    protected $fillable = ['intento_id', 'pregunta_id', 'opcion_id'];

    public function intento(): BelongsTo
    {
        return $this->belongsTo(Intento::class);
    }

    public function pregunta(): BelongsTo
    {
        return $this->belongsTo(Pregunta::class);
    }

    public function opcion(): BelongsTo
    {
        return $this->belongsTo(Opcion::class);
    }
}
