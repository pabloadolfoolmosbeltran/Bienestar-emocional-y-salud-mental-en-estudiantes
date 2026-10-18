<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticuloController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate(
            ['categoria' => ['sometimes', 'nullable', 'string', 'max:255']],
            [
                'categoria.string' => 'La categoría debe ser un texto.',
                'categoria.max' => 'La categoría es demasiado larga.',
            ]
        );

        $categoria = $request->query('categoria');

        return view('articulos.index', [
            'articulos' => Articulo::query()
                ->with('imagenRegistro')
                ->when($categoria, fn ($consulta) => $consulta->where('categoria', $categoria))
                ->latest()
                ->paginate(6)
                ->withQueryString(),
            'categoria' => $categoria,
        ]);
    }

    public function show(Articulo $articulo): View
    {
        $articulo->load('imagenRegistro');

        return view('articulos.show', compact('articulo'));
    }
}
