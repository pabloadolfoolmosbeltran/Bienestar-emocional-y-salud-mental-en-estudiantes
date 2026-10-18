@extends('layouts.app')

@section('titulo', 'Quiz orientativo | Pausa')

@section('contenido')
    <section class="page-intro">
        <div class="container quiz-shell">
            <p class="eyebrow mb-3">Un momento para reflexionar</p>
            <h1 class="mb-3">¿Cómo te has sentido últimamente?</h1>
            <p class="lead mb-0">Responde según tu experiencia. No hay respuestas buenas ni malas; este espacio es para observar cómo estás.</p>
        </div>
    </section>

    <section class="section-space">
        <div class="container quiz-shell">
            <div class="notice-card mb-4" role="note">
                <div class="d-flex gap-3">
                    <span class="fs-4" aria-hidden="true">ⓘ</span>
                    <div>
                        <h2 class="h5 mb-2">Antes de comenzar</h2>
                        <p class="mb-0">Este quiz es <strong>orientativo y no es un diagnóstico</strong>. No pedimos tu nombre. Si algo te preocupa, habla con una persona de confianza o busca orientación profesional.</p>
                    </div>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <h2 class="h5 alert-heading">Revisa tus respuestas</h2>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($preguntas->isEmpty())
                <div class="card card-lift">
                    <div class="card-body">
                        <h2 class="h4">El quiz no está disponible por ahora</h2>
                        <p class="text-muted-custom">Todavía no hay preguntas activas. Puedes explorar los artículos mientras tanto.</p>
                        <a class="btn btn-pausa" href="{{ route('informacion.index') }}">Ver información</a>
                    </div>
                </div>
            @else
                <div class="mb-4 mb-md-5">
                    <div class="d-flex justify-content-between align-items-center gap-3 mb-2">
                        <h2 class="h6 mb-0">Tu progreso</h2>
                        <span id="progreso-texto" class="small fw-bold text-muted-custom" aria-live="polite">0 de {{ $preguntas->count() }} respondidas</span>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Preguntas respondidas" aria-valuemin="0"
                         aria-valuemax="{{ $preguntas->count() }}" aria-valuenow="0" id="progreso-quiz">
                        <div class="progress-bar" style="width: 0%"></div>
                    </div>
                </div>

                <form id="formulario-quiz" method="post" action="{{ route('quiz.store') }}">
                    @csrf
                    @foreach ($preguntas as $pregunta)
                        <fieldset class="question-card mb-3 mb-md-4" data-pregunta>
                            <div class="eyebrow mb-2">Pregunta {{ $loop->iteration }} de {{ $preguntas->count() }}</div>
                            <legend>{{ $pregunta->texto }}</legend>
                            @foreach ($pregunta->opciones as $opcion)
                                <div class="form-check option-row">
                                    <input class="form-check-input @if ($errors->has("respuestas.{$pregunta->id}")) is-invalid @endif"
                                           type="radio"
                                           name="respuestas[{{ $pregunta->id }}]"
                                           id="opcion-{{ $opcion->id }}"
                                           value="{{ $opcion->id }}"
                                           required
                                           @checked(old("respuestas.{$pregunta->id}") == $opcion->id)>
                                    <label class="form-check-label ms-1" for="opcion-{{ $opcion->id }}">{{ $opcion->texto }}</label>
                                </div>
                            @endforeach
                            @error("respuestas.{$pregunta->id}")
                                <p class="text-danger fw-semibold mb-0" role="alert">{{ $message }}</p>
                            @enderror
                        </fieldset>
                    @endforeach

                    <div class="d-grid d-sm-flex justify-content-sm-between align-items-sm-center gap-3 mt-4">
                        <p class="small text-muted-custom mb-0">Al enviar, podrás ver una recomendación según tus respuestas.</p>
                        <button class="btn btn-pausa flex-shrink-0" type="submit">Ver mi resultado <span aria-hidden="true">→</span></button>
                    </div>
                </form>
            @endif
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const formulario = document.getElementById('formulario-quiz');
            if (!formulario) return;

            const bloques = [...formulario.querySelectorAll('[data-pregunta]')];
            const barra = document.getElementById('progreso-quiz');
            const relleno = barra.querySelector('.progress-bar');
            const texto = document.getElementById('progreso-texto');

            const actualizarProgreso = () => {
                const respondidas = bloques.filter(bloque => bloque.querySelector('input[type="radio"]:checked')).length;
                const porcentaje = Math.round((respondidas / bloques.length) * 100);
                relleno.style.width = porcentaje + '%';
                barra.setAttribute('aria-valuenow', respondidas);
                texto.textContent = respondidas + ' de ' + bloques.length + ' respondidas';
            };

            formulario.addEventListener('change', actualizarProgreso);
            actualizarProgreso();
        });
    </script>
@endpush
