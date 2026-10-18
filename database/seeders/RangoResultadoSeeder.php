<?php

namespace Database\Seeders;

use App\Models\RangoResultado;
use Illuminate\Database\Seeder;

class RangoResultadoSeeder extends Seeder
{
    public function run(): void
    {
        $rangos = [
            [
                'min' => 0, 'max' => 12, 'nivel' => 'bajo',
                'titulo' => 'Vas encontrando equilibrio',
                'recomendacion' => 'Tu respuesta sugiere que cuentas con varios recursos para afrontar tus días. Conserva las pausas, el descanso y las personas que te apoyan. Si algo te preocupa, hablarlo también es válido. Este resultado es orientativo y no es un diagnóstico.',
            ],
            [
                'min' => 13, 'max' => 24, 'nivel' => 'medio',
                'titulo' => 'Podrías necesitar una pausa',
                'recomendacion' => 'Parece que algunas exigencias están pesando en tu rutina. Elige un paso pequeño para hoy: priorizar una tarea, reservar tiempo para descansar o conversar con alguien de confianza. Si el malestar continúa o interfiere con tu vida diaria, considera buscar orientación profesional. Este resultado es orientativo y no es un diagnóstico.',
            ],
            [
                'min' => 25, 'max' => 36, 'nivel' => 'alto',
                'titulo' => 'Mereces apoyo en este momento',
                'recomendacion' => 'Tus respuestas muestran que estás viviendo varias dificultades a la vez. No tienes que resolverlo todo en soledad: habla con una persona de confianza y considera buscar apoyo de un profesional de salud mental o del servicio de orientación de tu institución. Este resultado es orientativo y no es un diagnóstico.',
            ],
        ];

        foreach ($rangos as $rango) {
            RangoResultado::updateOrCreate(
                ['nivel' => $rango['nivel']],
                $rango
            );
        }
    }
}
