<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function index(): View
    {
        return view('inicio', [
            'articulosRecientes' => Articulo::with('imagenRegistro')->latest()->take(3)->get(),
        ]);
    }
}
