<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DesarrolladorController extends Controller
{
    public function index(): View
    {
        return view('desarrolladores.index');
    }
}
