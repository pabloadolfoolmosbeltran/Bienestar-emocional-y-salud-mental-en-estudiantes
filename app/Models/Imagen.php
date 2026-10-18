<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model
{
    protected $table = 'imagenes';

    protected $fillable = [
        'archivo', 'ruta', 'tema', 'descripcion', 'autor', 'fuente', 'licencia', 'url_origen',
    ];
}
