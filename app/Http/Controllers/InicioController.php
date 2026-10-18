<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\View\View;

class InicioController extends Controller
{
    public function index(): View
    {
        return view('inicio', [
            'articulosRecientes' => Articulo::latest()->take(3)->get(),
        ]);
    }
}
