<?php

use App\Http\Controllers\ArticuloController;
use App\Http\Controllers\DesarrolladorController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;

Route::get('/', [InicioController::class, 'index'])->name('inicio');
Route::get('/informacion', [ArticuloController::class, 'index'])->name('informacion.index');
Route::get('/informacion/{articulo}', [ArticuloController::class, 'show'])->name('informacion.show');
Route::get('/quiz', [QuizController::class, 'index'])->name('quiz.index');
Route::post('/quiz', [QuizController::class, 'store'])->name('quiz.store');
Route::get('/quiz/resultado/{intento}', [QuizController::class, 'resultado'])->name('quiz.resultado');
Route::get('/desarrolladores', [DesarrolladorController::class, 'index'])->name('desarrolladores.index');
