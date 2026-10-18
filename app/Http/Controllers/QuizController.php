<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuardarQuizRequest;
use App\Models\Articulo;
use App\Models\Intento;
use App\Models\Opcion;
use App\Models\Pregunta;
use App\Models\RangoResultado;
use App\Models\Respuesta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use RuntimeException;

class QuizController extends Controller
{
    public function index(): View
    {
        return view('quiz.index', [
            'preguntas' => Pregunta::query()
                ->where('activa', true)
                ->with('opciones')
                ->orderBy('orden')
                ->orderBy('id')
                ->get(),
        ]);
    }

    public function store(GuardarQuizRequest $request): RedirectResponse
    {
        $respuestas = $request->validated()['respuestas'];

        $intento = DB::transaction(function () use ($respuestas): Intento {
            $opciones = Opcion::query()
                ->whereIn('id', array_values($respuestas))
                ->get(['id', 'pregunta_id', 'puntos'])
                ->keyBy('id');

            $intento = Intento::create();
            $puntaje = 0;
            $momento = now();
            $filas = [];

            foreach ($respuestas as $preguntaId => $opcionId) {
                $opcion = $opciones->get($opcionId);

                if (! $opcion || (int) $opcion->pregunta_id !== (int) $preguntaId) {
                    throw ValidationException::withMessages([
                        "respuestas.{$preguntaId}" => 'La opción elegida ya no está disponible para esta pregunta.',
                    ]);
                }

                $puntaje += (int) $opcion->puntos;
                $filas[] = [
                    'intento_id' => $intento->id,
                    'pregunta_id' => $preguntaId,
                    'opcion_id' => $opcionId,
                    'created_at' => $momento,
                    'updated_at' => $momento,
                ];
            }

            Respuesta::query()->insert($filas);

            $rango = RangoResultado::query()
                ->where('min', '<=', $puntaje)
                ->where('max', '>=', $puntaje)
                ->first();

            if (! $rango) {
                throw new RuntimeException('No existe un rango para el puntaje calculado.');
            }

            $intento->update([
                'puntaje_total' => $puntaje,
                'nivel' => $rango->nivel,
            ]);

            return $intento;
        });

        return redirect()->route('quiz.resultado', $intento);
    }

    public function resultado(Intento $intento): View
    {
        $rango = RangoResultado::query()
            ->where('min', '<=', $intento->puntaje_total)
            ->where('max', '>=', $intento->puntaje_total)
            ->firstOrFail();

        $puntajesPorCategoria = DB::table('respuestas')
            ->join('preguntas', 'respuestas.pregunta_id', '=', 'preguntas.id')
            ->join('opciones', 'respuestas.opcion_id', '=', 'opciones.id')
            ->where('respuestas.intento_id', $intento->id)
            ->select('preguntas.categoria')
            ->selectRaw('SUM(opciones.puntos) as puntaje')
            ->groupBy('preguntas.categoria')
            ->orderByDesc('puntaje')
            ->orderBy('preguntas.categoria')
            ->get();

        $categoriaPrincipal = $puntajesPorCategoria->first()?->categoria;
        $articulosRecomendados = $categoriaPrincipal
            ? Articulo::query()->with('imagenRegistro')->where('categoria', $categoriaPrincipal)->latest()->take(3)->get()
            : collect();

        return view('quiz.resultado', compact(
            'intento',
            'rango',
            'puntajesPorCategoria',
            'articulosRecomendados'
        ));
    }
}
