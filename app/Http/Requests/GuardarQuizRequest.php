<?php

namespace App\Http\Requests;

use App\Models\Opcion;
use App\Models\Pregunta;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class GuardarQuizRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'respuestas' => ['required', 'array'],
            'respuestas.*' => ['required', 'integer'],
        ];
    }

    public function messages(): array
    {
        return [
            'respuestas.required' => 'Responde todas las preguntas antes de continuar.',
            'respuestas.array' => 'Las respuestas enviadas no tienen el formato esperado.',
            'respuestas.*.required' => 'Elige una opción para cada pregunta.',
            'respuestas.*.integer' => 'La opción elegida no es válida.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $idsActivos = Pregunta::query()
                    ->where('activa', true)
                    ->pluck('id')
                    ->map(fn ($id) => (string) $id)
                    ->all();

                if ($idsActivos === []) {
                    $validator->errors()->add('respuestas', 'El quiz no tiene preguntas disponibles en este momento.');

                    return;
                }

                $respuestas = $this->input('respuestas');
                if (! is_array($respuestas)) {
                    return;
                }

                foreach (array_diff($idsActivos, array_map('strval', array_keys($respuestas))) as $idFaltante) {
                    $validator->errors()->add("respuestas.{$idFaltante}", 'Debes responder esta pregunta.');
                }

                $idsOpciones = array_values(array_filter(
                    $respuestas,
                    fn ($id) => is_scalar($id) && ctype_digit((string) $id)
                ));
                $preguntasDeOpciones = Opcion::query()
                    ->whereIn('id', $idsOpciones)
                    ->pluck('pregunta_id', 'id');

                foreach ($respuestas as $preguntaId => $opcionId) {
                    $clave = "respuestas.{$preguntaId}";

                    if (! in_array((string) $preguntaId, $idsActivos, true)) {
                        $validator->errors()->add($clave, 'Esta pregunta no está activa.');

                        continue;
                    }

                    if (! is_scalar($opcionId) || (int) $preguntasDeOpciones->get($opcionId) !== (int) $preguntaId) {
                        $validator->errors()->add($clave, 'La opción elegida no pertenece a esta pregunta.');
                    }
                }
            },
        ];
    }
}
