@extends('layouts.app')

@section('titulo', 'Tu resultado | Pausa')

@section('contenido')
    <section class="section-space">
        <div class="container quiz-shell">
            <p class="eyebrow mb-3">Tu resultado</p>
            <div class="result-banner p-4 p-md-5 mb-4">
                <div class="row g-4 align-items-center">
                    <div class="col-md-8">
                        <span class="result-level mb-3">Nivel {{ $intento->nivel }}</span>
                        <h1 class="display-6 mb-3">{{ $rango->titulo }}</h1>
                        <p class="mb-0">{{ $rango->recomendacion }}</p>
                    </div>
                    <div class="col-md-4">
                        <div class="score-box text-center">
                            <span class="d-block mb-2">Puntaje total</span>
                            <strong>{{ $intento->puntaje_total }}</strong>
                            <span class="d-block mt-2">puntos</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="notice-card mb-5" role="note">
                <strong>Recuerda:</strong> este quiz es orientativo y no es un diagnóstico. Si necesitas apoyo, habla con alguien de confianza o busca orientación profesional.
            </div>

            <section aria-labelledby="categorias-titulo" class="mb-5">
                <div class="section-heading mb-4">
                    <p class="eyebrow mb-2">Una mirada más cercana</p>
                    <h2 id="categorias-titulo" class="h3 mb-2">Puntaje por categoría</h2>
                    <p class="mb-0">Estos puntos resumen las opciones que elegiste en cada tema.</p>
                </div>
                <div class="row g-3">
                    @foreach ($puntajesPorCategoria as $categoria)
                        <div class="col-sm-6 col-lg-4">
                            <div class="category-score h-100 d-flex align-items-center justify-content-between gap-3">
                                <x-categoria :nombre="$categoria->categoria" />
                                <strong>{{ $categoria->puntaje }}</strong>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section aria-labelledby="recomendados-titulo">
                <div class="section-heading mb-4">
                    <p class="eyebrow mb-2">Para seguir explorando</p>
                    <h2 id="recomendados-titulo" class="h3 mb-2">Artículos que pueden ayudarte</h2>
                    <p class="mb-0">Lecturas relacionadas con el tema que obtuvo más puntos.</p>
                </div>
                <div class="row g-3">
                    @forelse ($articulosRecomendados as $articulo)
                        <div class="col-md-6 col-lg-4">
                            <article class="card card-lift">
                                <div class="card-body d-flex flex-column">
                                    <x-categoria :nombre="$articulo->categoria" />
                                    <h3 class="article-card-title h5 mt-3">
                                        <a href="{{ route('informacion.show', $articulo) }}">{{ $articulo->titulo }}</a>
                                    </h3>
                                    <p class="text-muted-custom mb-4">{{ $articulo->resumen }}</p>
                                    <a class="arrow-link mt-auto" href="{{ route('informacion.show', $articulo) }}">Leer artículo</a>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12"><p class="text-muted-custom">No hay artículos relacionados por ahora.</p></div>
                    @endforelse
                </div>
            </section>

            <div class="d-grid d-sm-flex gap-3 mt-5">
                <a class="btn btn-pausa" href="{{ route('informacion.index') }}">Explorar más información</a>
                <a class="btn btn-pausa-outline" href="{{ route('quiz.index') }}">Volver a realizar el quiz</a>
            </div>
        </div>
    </section>
@endsection
