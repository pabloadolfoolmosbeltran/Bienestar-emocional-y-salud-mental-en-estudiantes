<?php

namespace Tests\Feature;

use App\Models\Articulo;
use App\Models\Intento;
use App\Models\Opcion;
use App\Models\Pregunta;
use App\Models\RangoResultado;
use App\Models\Respuesta;
use Database\Seeders\ArticuloSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class CapaDatosTest extends TestCase
{
    use RefreshDatabase;

    public function test_migraciones_y_relaciones_del_dominio(): void
    {
        foreach (['preguntas', 'opciones', 'intentos', 'respuestas', 'rangos_resultado', 'articulos'] as $tabla) {
            $this->assertTrue(Schema::hasTable($tabla), "Falta la tabla {$tabla}");
        }

        $pregunta = Pregunta::create(['texto' => '¿Cómo te sientes?', 'categoria' => 'animo', 'orden' => 1]);
        $opcion = $pregunta->opciones()->create(['texto' => 'Bien', 'puntos' => 0]);
        $intento = Intento::create(['puntaje_total' => 0, 'nivel' => 'bajo']);
        $respuesta = $intento->respuestas()->create(['pregunta_id' => $pregunta->id, 'opcion_id' => $opcion->id]);

        $this->assertEquals($pregunta->id, $opcion->pregunta->id);
        $this->assertEquals($intento->id, $respuesta->intento->id);
        $this->assertEquals($pregunta->id, $respuesta->pregunta->id);
        $this->assertEquals($opcion->id, $respuesta->opcion->id);
        $this->assertCount(1, $pregunta->opciones);
        $this->assertCount(1, $intento->respuestas);

        $intento->delete();
        $this->assertDatabaseMissing('respuestas', ['id' => $respuesta->id]);
        $pregunta->delete();
        $this->assertDatabaseMissing('opciones', ['id' => $opcion->id]);
    }

    public function test_seeders_cargan_el_contenido_y_los_rangos_acordados(): void
    {
        $this->seed();

        $this->assertSame(12, Pregunta::count());
        $this->assertSame(48, Opcion::count());
        $this->assertSame(8, Articulo::count());
        $this->assertSame(3, RangoResultado::count());
        $this->assertSame(0, Respuesta::count());
        $this->assertSame(0, Intento::count());

        foreach (Pregunta::with('opciones')->get() as $pregunta) {
            $this->assertTrue($pregunta->activa);
            $this->assertSame([0, 1, 2, 3], $pregunta->opciones->pluck('puntos')->sort()->values()->all());
        }

        $this->assertSame(
            [[0, 12, 'bajo'], [13, 24, 'medio'], [25, 36, 'alto']],
            RangoResultado::orderBy('min')->get(['min', 'max', 'nivel'])->map(fn ($r) => [$r->min, $r->max, $r->nivel])->all()
        );
    }

    public function test_articulos_ampliados_conservan_identidad_y_se_muestran_como_html(): void
    {
        $this->seed(ArticuloSeeder::class);
        $originales = Articulo::orderBy('id')->get(['id', 'titulo', 'categoria']);
        $this->seed(ArticuloSeeder::class);

        $this->assertSame(8, Articulo::count());
        $this->assertEquals($originales, Articulo::orderBy('id')->get(['id', 'titulo', 'categoria']));

        $iniciosOriginales = [
            'Si llegas de trabajar y todavía tienes tareas',
            'La noche anterior, elige dos o tres temas prioritarios',
            'Si trabajas y estudias de noche, intenta reservar una hora',
            'Anota primero tus horarios fijos',
            'Antes de empezar, define una tarea concreta',
            'Cuando algo sale mal, observa si te estás diciendo frases',
            'Puedes comenzar con una frase simple',
            'Piensa en dos personas con quienes podrías conversar',
        ];

        foreach (Articulo::orderBy('id')->get() as $indice => $articulo) {
            $palabras = preg_split('/\s+/u', trim(strip_tags($articulo->contenido)));
            $this->assertGreaterThanOrEqual(350, count($palabras), $articulo->titulo);
            $this->assertLessThanOrEqual(600, count($palabras), $articulo->titulo);
            $this->assertStringContainsString($iniciosOriginales[$indice], $articulo->contenido);
            $this->assertStringContainsString('<h2>Para saber más</h2>', $articulo->contenido);
            $this->assertStringContainsString('COMPLETAR: verificar fuente', $articulo->contenido);
            $this->assertStringContainsString('Este sitio es orientativo y no reemplaza la atención de un profesional.', $articulo->contenido);
            $this->assertDoesNotMatchRegularExpression('/https?:\/\//i', $articulo->contenido);
        }

        $this->get(route('informacion.show', $originales->first()->id))
            ->assertOk()
            ->assertSee('<h2>Para saber más</h2>', false);
    }
}
