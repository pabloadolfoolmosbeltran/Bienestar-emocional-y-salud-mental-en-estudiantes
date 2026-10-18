@extends('layouts.app')

@section('titulo', 'Inicio | Pausa')

@section('contenido')
    <section class="hero py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <p class="eyebrow mb-3">Un espacio para estudiantes</p>
                    <h1 class="hero-title mb-4">Estudiar importa. <span>Sentirte bien también.</span></h1>
                    <p class="hero-copy mb-4">
                        Entre clases, trabajo y responsabilidades, cuidar tu bienestar emocional puede quedar al final.
                        Pausa reúne ideas sencillas para entender lo que sientes, organizarte y encontrar apoyo.
                    </p>
                    <div class="d-grid d-sm-flex gap-3">
                        <a class="btn btn-pausa" href="{{ route('informacion.index') }}">Explorar información <span aria-hidden="true">→</span></a>
                        <a class="btn btn-pausa-outline" href="{{ route('quiz.index') }}">Hacer el quiz orientativo</a>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="hero-panel p-4 p-md-5">
                        <span class="panel-icon mb-4" aria-hidden="true">✦</span>
                        <p class="eyebrow mb-2">Nuestro objetivo</p>
                        <h2 class="h3 mb-3">Un primer paso, a tu ritmo.</h2>
                        <p class="text-muted-custom mb-4">Queremos acercarte recursos claros y un espacio de reflexión. No tienes que resolver todo en un solo día.</p>
                        <div class="panel-line pt-3 d-flex align-items-center gap-3">
                            <span class="brand-mark flex-shrink-0" aria-hidden="true">♡</span>
                            <span class="fw-semibold">Tu bienestar merece atención y apoyo.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space" aria-labelledby="mensajes-titulo">
        <div class="container">
            <div class="section-heading mb-4 mb-md-5">
                <p class="eyebrow mb-2">Para recordar</p>
                <h2 id="mensajes-titulo" class="display-6 mb-3">Tres ideas para empezar</h2>
                <p class="mb-0">Pequeños gestos cotidianos pueden ayudarte a cuidar tu espacio de estudio y descanso.</p>
            </div>
            <div class="row g-3 g-lg-4">
                <div class="col-md-4">
                    <div class="message-card">
                        <span class="message-number">1 / DESCANSO</span>
                        <h3 class="mt-3">Pausar también cuenta</h3>
                        <p class="text-muted-custom mb-0">Descansar no es perder tiempo. Puedes hacer espacio para respirar y recuperar energía.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="message-card">
                        <span class="message-number">2 / APOYO</span>
                        <h3 class="mt-3">No tienes que hacerlo solo</h3>
                        <p class="text-muted-custom mb-0">Hablar con alguien de confianza puede ser un buen comienzo cuando algo te pesa.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="message-card">
                        <span class="message-number">3 / PROGRESO</span>
                        <h3 class="mt-3">Avanza a tu ritmo</h3>
                        <p class="text-muted-custom mb-0">Una tarea pequeña y posible suele ser mejor que exigirte terminar todo de una vez.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section-space surface-soft" aria-labelledby="recientes-titulo">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-end gap-3 mb-4 mb-md-5">
                <div class="section-heading">
                    <p class="eyebrow mb-2">Lecturas recientes</p>
                    <h2 id="recientes-titulo" class="display-6 mb-2">Ideas para tu día a día</h2>
                    <p class="mb-0">Artículos breves pensados para estudiantes con semanas exigentes.</p>
                </div>
                <a class="arrow-link flex-shrink-0" href="{{ route('informacion.index') }}">Ver todos los artículos</a>
            </div>
            <div class="row g-3 g-lg-4">
                @forelse ($articulosRecientes as $articulo)
                    <div class="col-md-6 col-lg-4">
                        <article class="card card-lift">
                            <x-articulo-imagen :articulo="$articulo" />
                            <div class="card-body d-flex flex-column">
                                <x-categoria :nombre="$articulo->categoria" />
                                <h3 class="article-card-title h4 mt-3">
                                    <a href="{{ route('informacion.show', $articulo) }}">{{ $articulo->titulo }}</a>
                                </h3>
                                <p class="text-muted-custom mb-4">{{ $articulo->resumen }}</p>
                                <a class="arrow-link mt-auto" href="{{ route('informacion.show', $articulo) }}">Leer artículo</a>
                            </div>
                        </article>
                    </div>
                @empty
                    <div class="col-12"><p class="mb-0">Pronto habrá artículos disponibles.</p></div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
