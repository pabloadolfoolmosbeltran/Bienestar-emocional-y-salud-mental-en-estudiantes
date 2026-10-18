@extends('layouts.app')

@section('titulo', 'Salud mental estudiantil en Bolivia | Pausa')

@php($datos = config('panorama'))
@php($familiaSegura = config('ayuda.familia_segura'))

@section('contenido')
    <section class="page-intro">
        <div class="container">
            <p class="eyebrow mb-3">Contexto y apoyo</p>
            <h1 class="mb-3">{{ $datos['titulo'] }}</h1>
            <p class="lead mb-0">{{ $datos['introduccion'] }}</p>
        </div>
    </section>

    <div class="container pt-4 pt-md-5">
        <div class="notice-card" role="note">
            <p class="fw-semibold mb-2">Alcance de esta página</p>
            <p class="mb-0">{{ $datos['nota_limites'] }}</p>
        </div>
    </div>

    @foreach ($datos['secciones'] as $clave => $seccion)
        <section class="section-space {{ $loop->even ? 'surface-soft' : '' }}" aria-labelledby="{{ $clave }}-titulo">
            <div class="container">
                <div class="section-heading mb-4 mb-md-5">
                    <h2 id="{{ $clave }}-titulo" class="display-6 mb-3">{{ $seccion['titulo'] }}</h2>
                    <p class="mb-0">{{ $seccion['introduccion'] }}</p>
                </div>

                <div class="row g-3 g-lg-4">
                    @foreach ($seccion['items'] as $item)
                        <div class="col-md-6 col-xl-4">
                            <article class="card card-lift">
                                <div class="card-body d-flex flex-column">
                                    <span class="category-pill align-self-start">{{ $item['tipo'] }}</span>
                                    <h3 class="h4 mt-3">{{ $item['titulo'] }}</h3>
                                    <p class="text-muted-custom">{{ $item['texto'] }}</p>
                                    <p class="small mb-0 mt-auto">
                                        Fuente:
                                        <a href="{{ $datos['fuentes'][$item['fuente']]['url'] }}" target="_blank" rel="noopener noreferrer">
                                            {{ $datos['fuentes'][$item['fuente']]['nombre'] }}
                                        </a>
                                    </p>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                @if ($clave === 'importancia')
                    <p class="small text-muted-custom mt-3 mb-0">{{ $datos['enlace_oms_pendiente'] }}</p>
                @elseif ($clave === 'estudiantes')
                    <div class="notice-card mt-4" role="note">
                        <span class="category-pill mb-2">Reflexión</span>
                        <p class="mb-0">{{ $datos['reflexion'] }}</p>
                    </div>
                @elseif ($clave === 'ayudar')
                    <div class="d-grid d-sm-flex gap-3 mt-4">
                        <a class="btn btn-pausa" href="{{ route('informacion.index') }}">Leer los artículos</a>
                        <a class="btn btn-pausa-outline" href="{{ route('quiz.index') }}">Hacer el quiz orientativo</a>
                    </div>
                @endif
            </div>
        </section>
    @endforeach

    <section class="section-space" aria-labelledby="apoyo-titulo">
        <div class="container">
            <div class="section-heading mb-4">
                <h2 id="apoyo-titulo" class="display-6 mb-3">{{ $datos['apoyo_titulo'] }}</h2>
                <p class="mb-0">{{ $datos['apoyo_texto'] }}</p>
            </div>
            <div class="row g-3 g-lg-4">
                <div class="col-lg-8">
                    <div class="card card-lift">
                        <div class="card-body p-4 p-md-5">
                            <span class="category-pill">Información oficial</span>
                            <h3 class="h4 mt-3">{{ $datos['familia_segura_titulo'] }}</h3>
                            <p class="mb-2">Línea gratuita: <strong>{{ $familiaSegura['telefono'] }}</strong></p>
                            <p class="mb-2">WhatsApp por mensaje de texto: <strong>{{ $familiaSegura['whatsapp'] }}</strong></p>
                            <p class="mb-3">Horario publicado: {{ $familiaSegura['horario'] }}.</p>
                            <p class="small text-muted-custom">{{ $datos['vigencia_texto'] }}</p>
                            <p class="small mb-0">
                                Fuente:
                                <a href="{{ $datos['fuentes'][$familiaSegura['fuente']]['url'] }}" target="_blank" rel="noopener noreferrer">
                                    {{ $datos['fuentes'][$familiaSegura['fuente']]['nombre'] }}
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="notice-card h-100" role="note">
                        <h3 class="h5 mb-3">{{ $datos['paso_titulo'] }}</h3>
                        <p>{{ $datos['paso_texto'] }}</p>
                        <p class="small mb-0">
                            Fuente:
                            <a href="{{ $datos['fuentes']['ops_prevencion']['url'] }}" target="_blank" rel="noopener noreferrer">
                                {{ $datos['fuentes']['ops_prevencion']['nombre'] }}
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space surface-soft" aria-labelledby="fuentes-titulo">
        <div class="container">
            <div class="section-heading mb-4">
                <h2 id="fuentes-titulo" class="display-6 mb-3">{{ $datos['fuentes_titulo'] }}</h2>
                <p class="mb-0">{{ $datos['fuentes_texto'] }} {{ $datos['fecha_consulta'] }}.</p>
            </div>
            <ul class="list-group mb-4">
                @foreach ($datos['fuentes'] as $fuente)
                    <li class="list-group-item py-3">
                        <a href="{{ $fuente['url'] }}" target="_blank" rel="noopener noreferrer">{{ $fuente['nombre'] }}</a>
                        <span class="d-block small text-muted-custom">Consultado: {{ $datos['fecha_consulta'] }}</span>
                    </li>
                @endforeach
            </ul>
            <p class="small text-muted-custom mb-4">{{ $datos['enlace_oms_pendiente'] }}</p>
            <div class="notice-card" role="note">{{ $datos['aviso'] }}</div>
        </div>
    </section>
@endsection
