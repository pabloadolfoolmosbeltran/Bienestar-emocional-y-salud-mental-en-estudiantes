<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RangoResultado extends Model
{
    protected $table = 'rangos_resultado';

    protected $fillable = ['min', 'max', 'nivel', 'titulo', 'recomendacion'];
}
