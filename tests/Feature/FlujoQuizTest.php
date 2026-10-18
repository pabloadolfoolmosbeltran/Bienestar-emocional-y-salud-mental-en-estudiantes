<?php

namespace Tests\Feature;

use App\Models\Articulo;
use App\Models\Intento;
use App\Models\Pregunta;
use App\Models\RangoResultado;
use App\Models\Respuesta;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FlujoQuizTest extends TestCase
{
    use RefreshDatabase;

    public function test_paginas_informativas_y_rutas_nombradas(): void
    {
        $this->seed();

        $this->get(route('inicio'))
            ->assertOk()
            ->assertViewHas('articulosRecientes', fn ($articulos) => $articulos->count() === 3);

        $this->get(route('informacion.index', ['categoria' => 'sueno']))
            ->assertOk()
            ->assertViewHas('articulos', fn ($articulos) => $articulos->count() === 1);

        $articulo = Articulo::firstOrFail();
        $this->get(route('informacion.show', $articulo))
            ->assertOk()
            ->assertSee($articulo->titulo);

        $this->get(route('desarrolladores.index'))->assertOk();
    }

    public function test_quiz_muestra_solo_preguntas_activas_ordenadas_con_opciones(): void
    {
        $this->seed();
        $inactiva = Pregunta::create([
            'texto' => 'Pregunta inactiva',
            'categoria' => 'estres',
            'orden' => 0,
            'activa' => false,
        ]);
        $inactiva->opciones()->create(['texto' => 'Opción inactiva', 'puntos' => 0]);

        $this->get(route('quiz.index'))
            ->assertOk()
            ->assertDontSee('Pregunta inactiva')
            ->assertSee('orientativo')
            ->assertViewHas('preguntas', function ($preguntas) {
                return $preguntas->count() === 12
                    && $preguntas->pluck('orden')->all() === range(1, 12)
                    && $preguntas->every(fn ($pregunta) => $pregunta->relationLoaded('opciones'));
            });
    }

    public function test_quiz_guarda_puntaje_nivel_desglose_y_articulos_relacionados(): void
    {
        $this->seed();
        $respuestas = Pregunta::with('opciones')->get()->mapWithKeys(function ($pregunta) {
            $puntos = $pregunta->categoria === 'estres' ? 3 : 0;

            return [$pregunta->id => $pregunta->opciones->firstWhere('puntos', $puntos)->id];
        })->all();

        $this->post(route('quiz.store'), ['respuestas' => $respuestas])
            ->assertRedirect();

        $intento = Intento::firstOrFail();
        $this->assertSame(9, $intento->puntaje_total);
        $this->assertSame('bajo', $intento->nivel);
        $this->assertSame(12, $intento->respuestas()->count());

        $this->get(route('quiz.resultado', $intento))
            ->assertOk()
            ->assertSee('no es un diagnóstico')
            ->assertViewHas('puntajesPorCategoria', fn ($puntajes) => $puntajes->first()->categoria === 'estres' && (int) $puntajes->first()->puntaje === 9)
            ->assertViewHas('articulosRecomendados', fn ($articulos) => $articulos->count() <= 3 && $articulos->every(fn ($articulo) => $articulo->categoria === 'estres'));
    }

    public function test_faltantes_y_opciones_ajenas_se_rechazan_sin_crear_intentos(): void
    {
        $this->seed();
        $preguntas = Pregunta::with('opciones')->orderBy('orden')->get();
        $respuestas = $preguntas->mapWithKeys(fn ($pregunta) => [$pregunta->id => $pregunta->opciones->first()->id])->all();
        $idFaltante = $preguntas->first()->id;
        unset($respuestas[$idFaltante]);

        $this->from(route('quiz.index'))
            ->post(route('quiz.store'), ['respuestas' => $respuestas])
            ->assertRedirect(route('quiz.index'))
            ->assertSessionHasErrors("respuestas.{$idFaltante}");

        $respuestas[$idFaltante] = $preguntas->last()->opciones->first()->id;
        $this->from(route('quiz.index'))
            ->post(route('quiz.store'), ['respuestas' => $respuestas])
            ->assertSessionHasErrors("respuestas.{$idFaltante}");

        $this->assertSame(0, Intento::count());
        $this->assertSame(0, Respuesta::count());
    }

    public function test_no_acepta_preguntas_inactivas_ni_quiz_sin_preguntas(): void
    {
        $this->seed();
        $preguntas = Pregunta::with('opciones')->get();
        $respuestas = $preguntas->mapWithKeys(fn ($pregunta) => [$pregunta->id => $pregunta->opciones->first()->id])->all();
        $preguntaInactiva = $preguntas->first();
        $preguntaInactiva->update(['activa' => false]);

        $this->from(route('quiz.index'))
            ->post(route('quiz.store'), ['respuestas' => $respuestas])
            ->assertSessionHasErrors("respuestas.{$preguntaInactiva->id}");

        Pregunta::query()->update(['activa' => false]);
        $this->from(route('quiz.index'))
            ->post(route('quiz.store'), ['respuestas' => []])
            ->assertSessionHasErrors('respuestas');

        $this->assertSame(0, Intento::count());
    }

    public function test_falta_de_rango_revierte_el_intento_y_sus_respuestas(): void
    {
        $this->seed();
        RangoResultado::query()->delete();
        $respuestas = Pregunta::with('opciones')->get()
            ->mapWithKeys(fn ($pregunta) => [$pregunta->id => $pregunta->opciones->first()->id])
            ->all();

        $this->withoutExceptionHandling();

        try {
            $this->post(route('quiz.store'), ['respuestas' => $respuestas]);
            $this->fail('Se esperaba un error por falta de rangos.');
        } catch (\RuntimeException $exception) {
            $this->assertSame('No existe un rango para el puntaje calculado.', $exception->getMessage());
        }

        $this->assertSame(0, Intento::count());
        $this->assertSame(0, Respuesta::count());
    }
}
