<?php

namespace Database\Seeders;

use App\Models\Pregunta;
use Illuminate\Database\Seeder;

class PreguntaSeeder extends Seeder
{
    public function run(): void
    {
        $preguntas = [
            ['estres', 'Al terminar tus actividades del día, ¿cuánto te cuesta dejar de pensar en tareas pendientes?', [
                'Puedo desconectarme con facilidad.', 'A veces sigo pensando en ellas.', 'Me cuesta desconectarme varias noches.', 'Casi nunca logro dejar de preocuparme.',
            ]],
            ['estres', 'Cuando se acercan exámenes o entregas, ¿cómo sientes la presión?', [
                'La manejo sin mayor dificultad.', 'Me inquieta un poco, pero sigo adelante.', 'Me abruma y dificulta concentrarme.', 'Me sobrepasa y afecta varias actividades.',
            ]],
            ['estres', '¿Con qué frecuencia haces una pausa breve cuando notas que estás muy tenso o tensa?', [
                'Casi siempre me doy una pausa.', 'A menudo recuerdo hacerla.', 'Rara vez hago una pausa.', 'Nunca hago una pausa aunque la necesite.',
            ]],
            ['sueno', 'Después de estudiar o trabajar hasta tarde, ¿cómo descansas?', [
                'Despierto con suficiente energía.', 'Algunos días me falta energía.', 'Frecuentemente despierto cansado o cansada.', 'Casi siempre despierto agotado o agotada.',
            ]],
            ['sueno', '¿Cuánto interrumpen tus pendientes el momento de ir a dormir?', [
                'No suelen interrumpirlo.', 'A veces retrasan mi descanso.', 'Lo retrasan varias noches.', 'Casi siempre me impiden descansar a tiempo.',
            ]],
            ['tiempo', '¿Cómo organizas tus tareas cuando coinciden estudio, trabajo y otras responsabilidades?', [
                'Defino prioridades realistas.', 'Hago un plan, aunque a veces se desordena.', 'Me cuesta decidir por dónde empezar.', 'Casi siempre siento que todo es urgente.',
            ]],
            ['tiempo', '¿Qué pasa cuando una tarea grande tiene una fecha cercana?', [
                'La divido en pasos y avanzo.', 'A veces la divido, aunque me atraso.', 'Suelo dejar gran parte para el final.', 'Me paralizo y no sé cómo comenzar.',
            ]],
            ['tiempo', '¿Con qué frecuencia reservas tiempo para comer y descansar durante una jornada larga?', [
                'Casi siempre reservo ese tiempo.', 'A veces lo logro.', 'Rara vez lo hago.', 'Casi nunca encuentro ese espacio.',
            ]],
            ['animo', 'En los últimos días, ¿cómo te has sentido al comenzar tus actividades?', [
                'Con ánimo suficiente para empezar.', 'Algo desanimado o desanimada algunos días.', 'Desanimado o desanimada muchos días.', 'Sin ánimo casi todos los días.',
            ]],
            ['animo', 'Cuando algo no sale como esperabas, ¿cómo te hablas a ti mismo o a ti misma?', [
                'Con comprensión; intento aprender.', 'Me critico un poco y luego continúo.', 'Me culpo con frecuencia.', 'Me trato con mucha dureza casi siempre.',
            ]],
            ['apoyo', 'Si una situación académica o personal te preocupa, ¿puedes hablar con alguien de confianza?', [
                'Sí, tengo a quien acudir.', 'A veces encuentro con quien hablar.', 'Me cuesta encontrar a alguien.', 'Siento que no tengo con quien hablar.',
            ]],
            ['apoyo', 'Cuando necesitas ayuda con una carga que no puedes manejar solo o sola, ¿qué haces?', [
                'Pido apoyo con confianza.', 'Pido apoyo después de pensarlo.', 'Me cuesta mucho pedir apoyo.', 'Evito pedir apoyo incluso cuando lo necesito.',
            ]],
        ];

        foreach ($preguntas as $indice => [$categoria, $texto, $opciones]) {
            $pregunta = Pregunta::updateOrCreate(
                ['orden' => $indice + 1],
                ['texto' => $texto, 'categoria' => $categoria, 'activa' => true]
            );

            foreach ($opciones as $puntos => $opcion) {
                $pregunta->opciones()->updateOrCreate(
                    ['puntos' => $puntos],
                    ['texto' => $opcion]
                );
            }
        }
    }
}
